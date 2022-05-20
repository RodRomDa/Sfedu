<?php

namespace Sfedu\ShopsManage\Model\ResourceModel\Review;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'review_id';
    protected $_eventPrefix = 'shopsmanage_review_collection';
    protected $_eventObject = 'review_collection';

    /**
     * Define resource model collection
     */
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\Review::class, \Sfedu\ShopsManage\Model\ResourceModel\Review::class);
    }
}
