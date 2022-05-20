<?php

namespace Sfedu\ShopsManage\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Sfedu\ShopsManage\Api\Data\ShopInterface;

/**
 * ShopRepository interface
 * @api
 */
interface ShopRepositoryInterface
{
    /**
     * Save shop.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface $shop
     * @return \Sfedu\ShopsManage\Api\Data\ShopInterface
     */
    public function save(ShopInterface $shop);

    /**
     * Retrieve shop.
     *
     * @param string $shopId
     * @return \Sfedu\ShopsManage\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($shopId);

    /**
     * Retrieve shops matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Sfedu\ShopsManage\Api\Data\ShopSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve list of shop towns
     *
     * @return string[]
     */
    public function getTowns();

    /**
     * Delete shop.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface $shop
     * @return bool true on success
     */
    public function delete(ShopInterface $shop);

    /**
     * Delete shop by ID.
     *
     * @param string $shopId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($shopId);
}
