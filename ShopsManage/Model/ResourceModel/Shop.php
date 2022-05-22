<?php
namespace Sfedu\ShopsManage\Model\ResourceModel;

/**
 * Shop resource model
 */
class Shop extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Shop products table name
     *
     * @var string
     */
    protected $_shopProductTable;

    /**
     * Shop store table name
     *
     * @var string
     */
    protected $_shopStoreTable;

    /**
     * Flag to determine if needed to delete some shop
     * products if store scope narrowed
     *
     * @var bool
     */
    protected $_needsProductStoreUpdate = false;


    /**
     * Shop constructor
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
        $this->_init('shopsmanage_shops_table', 'shop_id');
    }

    /**
     * Process shop data after save shop object
     *
     * Save related products ids
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\DataObject $object)
    {
        $this->saveStores($object)->saveProducts($object);
        return parent::_afterSave($object);
    }

    /**
     * Get ids of associated to shop products
     *
     * @param \Sfedu\ShopsManage\Model\Shop $shop
     * @return array
     */
    public function getProducts($shop)
    {
        $select = $this->getConnection()->select()->from(
            $this->getShopProductTable(),
            ['product_id']
        )->where(
            "{$this->getShopProductTable()}.shop_id = ?",
            $shop->getId()
        );

        $bind = ['shop_id' => (int)$shop->getId()];

        return $this->getConnection()->fetchCol($select, $bind);
    }

    /**
     * Get ids of associated to category products
     *
     * @param \Sfedu\ShopsManage\Model\Shop $shop
     * @return array
     */
    public function getStores($shop)
    {
        $shopId = (int)$shop->getId();

        $select = $this->getConnection()->select()->from(
            $this->getShopStoreTable(),
            ['store_id']
        )->where(
            "{$this->getShopStoreTable()}.shop_id = ?",
            $shopId
        );

        return $this->getConnection()->fetchCol($select, ['shop_id' => $shopId]);
    }

    /**
     * Shop product table name getter
     *
     * @return string
     */
    public function getShopProductTable()
    {
        if (!$this->_shopProductTable) {
            $this->_shopProductTable = $this->getTable('shopsmanage_shop_product');
        }
        return $this->_shopProductTable;
    }

    /**
     * Shop store table name getter
     *
     * @return string
     */
    public function getShopStoreTable()
    {
        if (!$this->_shopStoreTable) {
            $this->_shopStoreTable = $this->getTable('shopsmanage_shop_store');
        }
        return $this->_shopStoreTable;
    }

    /**
     * Save shops products
     *
     * @param \Sfedu\ShopsManage\Model\Shop $shop
     * @return $this
     */
    public function saveProducts($shop)
    {
        $id = $shop->getId();
        /**
         * new shop-product relationships
         */
        $products = $shop->getProductIds();

        if ($products === null) {
            return $this;
        }

        /**
         * old shop-product relationships
         */
        $oldProducts = $this->getProducts($shop);

        /**
         * to insert
         */
        $insert = array_diff($products, $oldProducts);
        /**
         * to delete
         */
        $delete = array_diff($oldProducts, $products);

        $connection = $this->getConnection();

        /**
         * Delete products from shop
         */
        if (!empty($delete)) {
            $cond = ['product_id IN(?)' => $delete, 'shop_id=?' => $id];
            $connection->delete($this->getShopProductTable(), $cond);
        }

        /**
         * Add products to shop
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId) {
                $data[] = [
                    'shop_id' => (int)$id,
                    'product_id' => (int)$productId,
                ];
            }
            $connection->insertMultiple($this->getShopProductTable(), $data);
        }

        /**
         * Delete some products,
         * that don't match new store view
         */
        if ($this->_needsProductStoreUpdate) {
            $this->_updateProductStore($shop);
            $this->_needsProductStoreUpdate = false;
        }

        return $this;
    }

    /**
     * Unlink products from shop
     * that don't match updated store scope
     *
     * @param \Sfedu\ShopsManage\Model\Shop $shop
     */
    protected function _updateProductStore($shop)
    {
        $websiteIds = $shop->getWebsites();
        if (isset($websiteIds)) {
            $connection = $this->getConnection();

            $matchWebsite = $connection->select()
                ->from(['product_website' => $this->getTable('catalog_product_website')])
                ->where(
                    "product_website.website_id IN (?)",
                    $websiteIds
                );
            $select = $connection->select()
                    ->from(
                        ['outer' => $this->getShopProductTable()]
                    )->exists($matchWebsite, "outer.product_id = product_website.product_id", false)
                    ->where("outer.shop_id = :cur_id")
                    ->deleteFromSelect('outer');

            $connection->query($select, ['cur_id' => $shop->getId()]);
        }
    }

    /**
     * Save shops store views
     *
     * @param \Sfedu\ShopsManage\Model\Shop $shop
     * @return $this
     */
    public function saveStores($shop)
    {
        $id = $shop->getId();
        /**
         * new shop-store relationships
         */
        $newStores = $shop->getStores();

        if ($newStores === null) {
            return $this;
        }

        /**
         * old shop-store relationships
         */
        $oldStores = $this->getStores($shop);

        /**
         * to insert
         */
        $insert = array_diff($newStores, $oldStores);
        /**
         * to delete
         */
        $delete = array_diff($oldStores, $newStores);

        $connection = $this->getConnection();

        /**
         * Delete stores from shop
         */
        if (!empty($delete)) {
            $this->_needsProductStoreUpdate = true;
            $cond = ['store_id IN(?)' => $delete, 'shop_id=?' => $id];
            $connection->delete($this->getShopStoreTable(), $cond);
        }

        /**
         * Add stores to shop
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'shop_id' => (int)$id,
                    'store_id' => (int)$storeId,
                ];
            }
            $connection->insertMultiple($this->getShopStoreTable(), $data);
        }

        return $this;
    }
}
