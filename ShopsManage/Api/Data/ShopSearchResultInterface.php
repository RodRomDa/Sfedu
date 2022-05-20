<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sfedu\ShopsManage\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for shop search results
 * @api
 */
interface ShopSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get shops list.
     *
     * @return \Sfedu\ShopsManage\Api\Data\ShopInterface[]
     */
    public function getItems();

    /**
     * Set shops list.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
