<?php

namespace Sfedu\ShopsManage\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Api\Data\ShopSearchResultInterfaceFactory;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Model\Config\ShopConfig;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\Collection;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\Collection as ShopCollection;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;

/**
 * Class ShopRepository
 *
 * Provides service to retrieve and save shops
 */
class ShopRepository implements ShopRepositoryInterface
{
    /**
     * @var ShopFactory
     */
    protected $shopFactory;

    /**
     * @var ShopCollection
     */
    protected $shopCollection;

    /**
     * @var ShopSearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var ShopConfig
     */
    protected $config;

    /**
     * ShopRepository constructor.
     * @param \Sfedu\ShopsManage\Model\ShopFactory $shopFactory
     * @param ShopCollectionFactory $shopCollectionFactory
     * @param ShopSearchResultInterfaceFactory $shopSearchResultInterfaceFactory
     */
    public function __construct(
        ShopFactory $shopFactory,
        ShopCollectionFactory $shopCollectionFactory,
        ShopSearchResultInterfaceFactory $shopSearchResultInterfaceFactory,
        ShopConfig $config
    ) {
        $this->shopFactory = $shopFactory;
        $this->shopCollection = $shopCollectionFactory->create();
        $this->searchResultFactory = $shopSearchResultInterfaceFactory;
        $this->config = $config;
    }

    /**
     * Retrieve shop.
     *
     * @param string $shopId
     * @return \Sfedu\ShopsManage\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $shop = $this->shopFactory->create();
        $this->shopCollection->getResource()->load($shop, $id);
        if (! $shop->getId()) {
            throw new NoSuchEntityException(__('Unable to find shop with ID "%1"', $id));
        }
        return $shop;
    }

    /**
     * Save shop.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface $shop
     * @return \Sfedu\ShopsManage\Api\Data\ShopInterface
     */
    public function save(ShopInterface $shop)
    {
        $this->shopCollection->getResource()->save($shop);
        return $shop;
    }

    /**
     * Delete shop.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface $shop
     * @return bool true on success
     */
    public function delete(ShopInterface $shop)
    {
        try {
            $this->shopCollection->getResource()->delete($shop);
            return true;
        } catch (\Exception $e) {
        }
        return false;
    }

    /**
     * Delete shop by ID.
     *
     * @param string $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($id)
    {
        $shop = $this->getById($id);
        try {
            $this->shopCollection->getResource()->delete($shop);
            return true;
        } catch (\Exception $e) {
        }
        return false;
    }

    /**
     * Retrieve shops matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Sfedu\ShopsManage\Api\Data\ShopSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->shopCollection;

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Retrieve list of shop towns
     *
     * @return string[]
     */
    public function getTowns()
    {
        return $this->config->getTowns();
    }

    /**
     * Add filters
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param ShopCollection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Add sort orders
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param ShopCollection $collection
     */
    public function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Add paging
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param ShopCollection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * Combine search result
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param ShopCollection $collection
     * @return \Sfedu\ShopsManage\Api\Data\ShopSearchResultInterface
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
