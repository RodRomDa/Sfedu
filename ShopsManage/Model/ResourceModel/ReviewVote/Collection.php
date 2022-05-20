<?php

namespace Sfedu\ShopsManage\Model\ResourceModel\ReviewVote;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'shopsmanage_review_vote_collection';
    protected $_eventObject = 'review_vote_collection';

    /**
     *  Define resource model collection
     */
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\ReviewVote::class, \Sfedu\ShopsManage\Model\ResourceModel\ReviewVote::class);
    }

    /**
     *  Set filter to specific review
     *
     *  @param int $reviewId
     *  @return $this
     */
    public function setReviewFilter($reviewId)
    {
        return $this->addFilter('review_id', $reviewId);
    }

    /**
     *  Set ratings order
     *
     *  @return $this
     */
    public function setRatingSortOrder()
    {
        $this->join(
            ['rating' => $this->getTable('shopsmanage_rating')],
            "main_table.rating_id = rating.rating_id",
            []
        )->addOrder('rating.name', 'ASC');
        return $this;
    }
}
