<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Shop\Listing;

use Magento\Customer\Model\Session;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\Grid\Collection;

/**
 * Class ShopListing
 *
 * Provides data for shop list in frontend
 */
class ShopListingFront extends ShopListing
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     *@var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var PoolInterface
     */
    private $pool;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * ShopListing constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Session $customerSession
     * @param ArrayManager $arrayManager
     * @param FilterBuilder $filterBuilder
     * @param PoolInterface $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $shopCollection,
        Session $customerSession,
        ArrayManager $arrayManager,
        FilterBuilder $filterBuilder,
        StoreManagerInterface $storeManager,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->arrayManager = $arrayManager;
        $this->storeManager = $storeManager;
        $this->pool = $pool;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $shopCollection,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     *  Populates update url with custormer id
     */
    protected function prepareUpdateUrl()
    {
        $this->arrayManager->set(
            'config/filter_url_params/customer_id',
            $this->data,
            $this->customerSession->getCustomer()->getId()
        );
    }

    /**
     * Return data for shop list
     *
     * @return array
     */
    public function getData()
    {
        //Only active shops
        $this->setActiveFilter();
        //In a current store view
        $this->setStoreFilter();

//        if (!$this->getCollection()->isLoaded()) {
//            $this->getCollection()->load();
//        }
//
//        $this->data = array_merge($this->data, parent::getData());
        $this->data = array_merge($this->data, parent::getData());

        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($this->data);
        }

        return $this->data;
    }

    /**
     * Set active fitler
     */
    protected function setActiveFilter()
    {
        $filter = $this->filterBuilder
            ->setField('is_active')
            ->setValue(1)
            ->setConditionType('eq')
            ->create();
        $this->addFilter($filter);
    }

    /**
     * Set store view filter
     */
    protected function setStoreFilter()
    {
        $curStore = $this->storeManager->getStore();
        $this->getCollection()->addStoreFilter($curStore);
    }

    /**
     * Return meta
     */
    public function getMeta()
    {
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }
}
