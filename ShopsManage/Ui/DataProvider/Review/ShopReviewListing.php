<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Review;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Sfedu\ShopsManage\Api\Data\RatingInterface;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\Grid\Collection as ShopCollection;

class ShopReviewListing extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     *@var RatingRepositoryInterface
     */
    private $ratingRepository;

    /**
     * ShopReviewListing constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ShopCollection $shopCollection
     * @param RatingRepositoryInterface $ratingRepository
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ShopCollection $shopCollection,
        RatingRepositoryInterface $ratingRepository,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $shopCollection;
        $this->ratingRepository = $ratingRepository;
        $this->filterBuilder = $filterBuilder;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }
    /**
     * Return data for shops reviews list
     *
     * @return array
     */
    public function getData()
    {
        $this->collection->addRatingAggregations(
            $this->ratingRepository->getAll()
        )->addReviewsCount();

        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $this->data = array_merge($this->data, parent::getData());

        return $this->data;
    }

    /**
     * Add fulltext filter to search
     */
    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == 'fulltext') {
            $titleFilter = $this->filterBuilder->setField('main_table.title')
                ->setValue(sprintf('%%%s%%', $filter->getValue()))
                ->setConditionType('like')
                ->create();
            parent::addFilter($titleFilter);
        } else {
            parent::addFilter($filter);
        }
    }

    /**
     * Return meta
     */
    public function getMeta()
    {
        $meta = parent::getMeta();
        $ratings = $this->ratingRepository->getAll();
        $num = 1;
        foreach ($ratings as $rating) {
            $meta['shop_review_grid_listing_columns']['children'][$this->getRatingColumnName($rating)] =
                $this->getRatingColumnMeta($rating, $num);
            $num++;
        }

        return $meta;
    }

    public function getRatingColumnMeta(RatingInterface $rating, $num = 1)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'dataType' => 'text',
                        'component' => 'Sfedu_ShopsManage/js/grid/columns/rating-column',
                        'componentType' => 'column',
                        'label' => $rating->getName(),
                        'filter' => 'text',
                        'sortOrder' => 10*$num,
                        'maxStars' => $rating->getStarsNum(),
                    ],
                ],
            ],
            'attributes' => [
                'class' => 'Magento\\Ui\\Component\\Listing\\Columns\\Column',
                'component' => 'Sfedu_ShopsManage/js/grid/columns/rating-column',
                'name' => $this->getRatingColumnName($rating),
                'sortOrder' => '10',
            ]
        ];
    }

    public function getRatingColumnName(RatingInterface $rating)
    {
        return 'rating_' . $rating->getId();
    }
}
