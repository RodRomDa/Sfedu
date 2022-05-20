<?php


namespace Sfedu\ShopsManage\Model\ResourceModel\Rating;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'rating_id';
    protected $_eventPrefix = 'shopsmanage_rating_collection';
    protected $_eventObject = 'rating_collection';
    /**
     * Define resource model collection
     */
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\Rating::class, \Sfedu\ShopsManage\Model\ResourceModel\Rating::class);
    }
}
