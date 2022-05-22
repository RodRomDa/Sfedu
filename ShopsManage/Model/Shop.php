<?php
namespace Sfedu\ShopsManage\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Model\Shop\FileInfo;

/**
 * Shop Model
 */
class Shop extends AbstractModel implements ShopInterface, IdentityInterface
{
    /**
     * Cache properties for auto block updates
     */
    const CACHE_TAG = 'sfedu_shopsmanage_shop';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'sfedu_shopsmanage_shop';

    /**
     * @var FileInfo $fileInfo
     */
    protected $fileInfo;

    /**
     * @var ResourceModel\Shop
     */
    protected $shopResource;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Shop constructor
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param FileInfo $fileInfo
     * @param ResourceModel\Shop $shopResource
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        FileInfo $fileInfo,
        ResourceModel\Shop $shopResource,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->fileInfo = $fileInfo;
        $this->shopResource = $shopResource;
        $this->storeManager = $storeManager;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Resource model initializtion
     */
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\ResourceModel\Shop::class);
    }

    /**
     * Return unique ID(s) for each shop in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::SHOP_ID);
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Get telephone number
     *
     * @return string
     */
    public function getTel()
    {
        return $this->getData(self::TEL);
    }

    /**
     * Get open time
     *
     * @return string
     */
    public function getOpenTime()
    {
        return $this->getData(self::OPEN_TIME);
    }

    /**
     * Get close time
     *
     * @return string
     */
    public function getCloseTime()
    {
        return $this->getData(self::CLOSE_TIME);
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->getData(self::TOWN);
    }

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Is content set
     *
     * @return bool
     */
    public function hasContent()
    {
        return $this->getContent() != null;
    }

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Is image set
     *
     * @return bool
     */
    public function hasImage()
    {
        return $this->getImage() != null;
    }

    /**
     * Get image url
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->fileInfo->getAbsolutePath($this->getImage());
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return ShopInterface
     */
    public function setId($id)
    {
        return $this->setData(self::SHOP_ID, $id);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ShopInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ShopInterface
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Set telephone number
     *
     * @param string $tel
     * @return ShopInterface
     */
    public function setTel($tel)
    {
        return $this->setData(self::TEL, $tel);
    }

    /**
     * Set open time
     *
     * @param string $opentime
     * @return ShopInterface
     */
    public function setOpenTime($opentime)
    {
        return $this->setData(self::OPEN_TIME, $opentime);
    }

    /**
     * Set town
     *
     * @param string $town
     * @return ShopInterface
     */
    public function setTown($town)
    {
        return $this->setData(self::TOWN, $town);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ShopInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set image
     *
     * @param string $image
     * @return ShopInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return ShopInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return ShopInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return ShopInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get meta information
     *
     * @return array
     */
    public function getMeta()
    {
        return [
            self::META_TITLE => $this->getData(self::META_TITLE),
            self::META_KEYS => $this->getData(self::META_KEYS),
            self::META_DESCR => $this->getData(self::META_DESCR)
        ];
    }

    /**
     * Set meta information
     *
     * @param array $meta
     * @return ShopInterface
     */
    public function setMeta($meta)
    {
        $this->setData(self::META_TITLE, $meta[self::META_TITLE]);
        $this->setData(self::META_KEYS, $meta[self::META_KEYS]);
        return $this->setData(self::META_DESCR, $meta[self::META_DESCR]);
    }


    /**
     * Retrieve array of product id's for shop
     *
     * @return int[]
     */
    public function getProductIds()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('loaded_product_ids');
        if ($array === null) {
            $array = $this->shopResource->getProducts($this);
            $this->setData('loaded_product_ids', $array);
        }
        return $array;
    }

    /**
     * Retrieve array of store view id's for shop
     *
     * @return int[]
     */
    public function getStores()
    {
        $array = $this->getData('store_ids');
        if ($array === null) {
            $array = $this->shopResource->getStores($this);
            $this->setData('store_ids', $array);
        }
        return $array;
    }

    /**
     * Retrieve array of corresponding to shop websites
     *
     * @return int[]
     */
    public function getWebsites()
    {
        $storeIds = $this->getStores();
        if (in_array(Store::DEFAULT_STORE_ID, $storeIds)) {
            return null;
        }
        $websites = [];
        foreach ($storeIds as $id) {
            $websites[] = $this->storeManager->getStore($id)->getWebsiteId();
        }
        return array_unique($websites);
    }

    /**
     * Test if shop has such store view
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function hasStore($store)
    {
        $storeId = $store->getId();

        return in_array($storeId, $this->getStores()) || in_array(Store::DEFAULT_STORE_ID, $this->getStores());
    }
}
