<?php

namespace Sfedu\ShopsManage\Api\Data;

use Magento\Store\Api\Data\StoreInterface;

/**
 * Shop interface
 * @api
 */
interface ShopInterface
{
    /**
     * Constants for keys of data array.
     */
    const SHOP_ID      = 'shop_id';
    const TITLE         = 'title';
    const ADDRESS    = 'address';
    const TEL    = 'tel';
    const OPEN_TIME    = 'open_time';
    const CLOSE_TIME    = 'close_time';
    const TOWN    = 'town';
    const CONTENT       = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';
    const IMAGE     = 'image';
    const META_TITLE     = 'meta_title';
    const META_KEYS = 'meta_keys';
    const META_DESCR = 'meta_descr';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress();

    /**
     * Get telephone number
     *
     * @return string
     */
    public function getTel();

    /**
     * Get open time
     *
     * @return string
     */
    public function getOpenTime();

    /**
     * Get close time
     *
     * @return string
     */
    public function getCloseTime();

    /**
     * Get town
     *
     * @return string
     */
    public function getTown();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Is content set
     *
     * @return bool
     */
    public function hasContent();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Is image set
     *
     * @return bool
     */
    public function hasImage();

    /**
     * Get image url
     *
     * @return string|null
     */
    public function getImageUrl();

    /**
     * Set ID
     *
     * @param int $id
     * @return ShopInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return ShopInterface
     */
    public function setTitle($title);

    /**
     * Set address
     *
     * @param string $address
     * @return ShopInterface
     */
    public function setAddress($address);

    /**
     * Set telephone number
     *
     * @param string $tel
     * @return ShopInterface
     */
    public function setTel($tel);

    /**
     * Set open time
     *
     * @param string $opentime
     * @return ShopInterface
     */
    public function setOpenTime($opentime);

    /**
     * Set town
     *
     * @param string $town
     * @return ShopInterface
     */
    public function setTown($town);

    /**
     * Set content
     *
     * @param string $content
     * @return ShopInterface
     */
    public function setContent($content);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return ShopInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return ShopInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return ShopInterface
     */
    public function setIsActive($isActive);

    /**
     * Set image
     *
     * @param string $image
     * @return ShopInterface
     */
    public function setImage($image);

    /**
     * Object data getter
     *
     * @param string $key
     * @param string|int $index
     * @return mixed
     */
    public function getData($key = '', $index = null);

    /**
     * Overwrite data in the object.
     *
     * @param string|array $key
     * @param mixed $value
     * @return $this
     */
    public function setData($key, $value = null);

    /**
     * Check if property exists
     *
     * @param string $key
     * @return bool
     */
    public function hasData($key = '');

    /**
     * Get meta information
     *
     * @return array
     */
    public function getMeta();

    /**
     * Set meta information
     *
     * @param array $meta
     * @return ShopInterface
     */
    public function setMeta(array $meta);

    /**
     * Retrieve array of product id's for shop
     *
     * @return int[]
     */
    public function getProductIds();

    /**
     * Retrieve array of store view id's for shop
     *
     * @return int[]
     */
    public function getStores();

    /**
     * Retrieve array of corresponding to shop websites
     *
     * @return int[]
     */
    public function getWebsites();

    /**
     * Test if shop has such store view
     *
     * @param StoreInterface $store
     * @return bool
     */
    public function hasStore($store);

    /**
     * Return unique ID(s) for each shop in system
     *
     * @return string[]
     */
    public function getIdentities();
}
