<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Shop\Listing;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\Grid\Collection;

class ShopListing extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * ShopListing constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $shopCollection
     * @param FilterBuilder $filterBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $shopCollection,
        FilterBuilder $filterBuilder,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $shopCollection;
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
     * Return data for shop list
     *
     * @return array
     */
    public function getData()
    {
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
            $this->getCollection()->addFieldToFilter(
                ['main_table.title',
                 'main_table.address',
                 'main_table.town',
                 'main_table.content',
                 'main_table.meta_keys'],
                [
                    ['like' => sprintf('%%%s%%', $filter->getValue())],
                    ['like' => sprintf('%%%s%%', $filter->getValue())],
                    ['like' => sprintf('%%%s%%', $filter->getValue())],
                    ['like' => sprintf('%%%s%%', $filter->getValue())],
                    ['like' => sprintf('%%%s%%', $filter->getValue())],
                ]
            );
        } elseif ($filter->getField() == 'open_time') {
            $this->filterBuilder->setValue($filter->getValue());
            $this->filterBuilder->setConditionType($filter->getConditionType());
            if ($filter->getConditionType() === 'gteq') {
                $this->filterBuilder->setField('open_time');
            } elseif ($filter->getConditionType() === 'lteq') {
                $this->filterBuilder->setField('close_time');
            }
            $filter = $this->filterBuilder->create();
            parent::addFilter($filter);
        } else {
            parent::addFilter($filter);
        }
    }

    public function addOrder($field, $direction)
    {
        parent::addOrder($field, $direction);
        if ($field == 'open_time') {
            parent::addOrder('close_time', $direction);
        }
    }
}
