<?php


namespace Sfedu\ShopsManage\Model\ResourceModel;


class Rating extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Rating constructor
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
        $this->_init('shopsmanage_rating', 'rating_id');
    }
}
