<?php
namespace Sfedu\ShopsManage\Model\ResourceModel\Shop;

use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Sfedu\ShopsManage\Api\Data\RatingInterface;

/**
 * Shop Resource Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'shop_id';
    protected $_eventPrefix = 'sfedu_shopsmanage_shop_collection';
    protected $_eventObject = 'shop_collection';

    /**
     * Define resource model collection
     */
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\Shop::class, \Sfedu\ShopsManage\Model\ResourceModel\Shop::class);
    }

    /**
     * Add filter for store view
     *
     * @param $store StoreInterface
     */
    public function addStoreFilter($store)
    {
        $storeId = $store->getId();
        $this->join(
            ['store' => $this->getTable('shopsmanage_shop_store')],
            "main_table.shop_id = store.shop_id",
            []
        );
        $this->addFieldToFilter(
            "store.store_id",
            [
                $storeId,
                Store::DEFAULT_STORE_ID
            ]
        );
    }

    /**
     * Add Ratings aggregations to collection
     *
     * @param RatingInterface[] $ratings
     */
    public function addRatingAggregations($ratings)
    {
        $this->getSelect()->joinLeft(
            ['reviews' => $this->getTable('shopsmanage_review')],
            "main_table.shop_id = reviews.shop_id",
            []
        )->joinLeft(
            ['rating' => $this->getTable('shopsmanage_review_rating')],
            "reviews.review_id = rating.review_id",
            []
        )->group('main_table.shop_id');

        $connection = $this->getConnection();
        foreach ($ratings as $rating) {
            $id = $rating->getId();
            $caseSql = $connection->getCaseSql('rating.rating_id', [$id => 'rating.value']);
            $this->addExpressionFieldToSelect(
                'rating_' . $id,
                $connection->getIfNullSql("(SUM({{rating}})/COUNT({{rating}}))", 0),
                ['rating'=>$caseSql]
            );
        }

        return $this;
    }

    public function addReviewsCount()
    {
        $this->addExpressionFieldToSelect('reviews', "COUNT(DISTINCT {{review_id}})", ['review_id' =>'reviews.review_id']);

        return $this;
    }
}
