<?php

namespace Sfedu\ShopsManage\Model\ResourceModel;

class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Review ratings table name
     *
     * @var string
     */
    protected $_reviewRatingTable;

    /**
     * Review constructor
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('shopsmanage_review', 'review_id');
    }

    /**
     * Shop product table name getter
     *
     * @return string
     */
    public function getReviewRatingTable()
    {
        if (!$this->_reviewRatingTable) {
            $this->_reviewRatingTable = $this->getTable('shopsmanage_review_rating');
        }
        return $this->_reviewRatingTable;
    }

    /**
     * Process ratings data after save review object
     *
     * Save related products ids
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\DataObject $object)
    {
        $this->saveRatings($object);
        return parent::_afterSave($object);
    }

    /**
     * Get rating ids of review
     *
     * @param \Sfedu\ShopsManage\Model\Review $review
     * @return array
     */
    public function getRatingIds($review)
    {
        $select = $this->getConnection()->select()->from(
            $this->getReviewRatingTable(),
            ['rating_id']
        )->where(
            "{$this->getReviewRatingTable()}.review_id = ?",
            $review->getId()
        );

        $bind = ['review_id' => (int)$review->getId()];

        return $this->getConnection()->fetchCol($select, $bind);
    }

    /**
     * Save review ratings
     *
     * @param \Sfedu\ShopsManage\Model\Review $review
     * @return $this
     */
    public function saveRatings($review)
    {
        $reviewId = $review->getId();
        $ratings = $review->getRatings();
        $ratingsMapped = [];
        foreach ($ratings as $rating) {
            $ratingsMapped[$rating->getRatingId()] = $rating;
        }

        $newRatingIds = array_keys($ratingsMapped);
        $oldRatingIds = $this->getRatingIds($review);

        /**
         * to insert
         */
        $insert = array_diff($newRatingIds, $oldRatingIds);

        /**
         * to delete
         */
        $delete = array_diff($oldRatingIds, $newRatingIds);

        /**
         * to update
         */
        $update = array_intersect($newRatingIds, $oldRatingIds);

        /**
         * Add reviews to shop
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $id) {
                $rating = $ratingsMapped[$id];
                $data[] = [
                    'review_id' => (int)$reviewId,
                    'rating_id' => (int)$rating->getRatingId(),
                    'value' => (int)$rating->getValue(),
                ];
            }
            $this->getConnection()->insertMultiple($this->getReviewRatingTable(), $data);
        }

        return $this;
    }
}
