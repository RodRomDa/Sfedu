<?php


namespace Sfedu\ShopsManage\Model\ResourceModel;

/**
 * ReviewVote resource model
 */
class ReviewVote extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * ReviewVote constructor
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
        $this->_init('shopsmanage_review_rating', 'entity_id');
    }
}
