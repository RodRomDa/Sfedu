<?php


namespace Sfedu\ShopsManage\Api\Data;


interface ReviewInterface
{
    /**
     * Constants for keys of data array.
     */
    const REVIEW_ID      = 'review_id';
    const TITLE         = 'title';
    const DETAIL   = 'detail';
    const NICKNAME   = 'nickname';
    const SHOP_ID   = 'shop_id';
    const CREATED_AT   = 'created_at';
    const IS_APPROVED   = 'is_approved';
    const CUSTOMER_ID   = 'customer_id';

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
     * Get detail
     *
     * @return string|null
     */
    public function getDetail();

    /**
     * Get nickname
     *
     * @return string|null
     */
    public function getNickname();

    /**
     * Get reviewed shop id
     *
     * @return int|null
     */
    public function getShopId();

    /**
     * Get customer id of review
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Get review creation date
     *
     * @return string|null
     */
    public function getCreationDate();

    /**
     * Get review ratings
     *
     * @return \Sfedu\ShopsManage\Api\Data\RatingVoteInterface[]
     */
    public function getRatings();

    /**
     * Get review is approved or not
     *
     * @return bool
     */
    public function getIsApproved();

    /**
     * Set customer id of review
     *
     * @param int $customerId
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     */
    public function setCustomerId($customerId);

    /**
     * Set shop id of review
     *
     * @param int $shopId
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     */
    public function setShopId($shopId);

    /**
     * Set review is approved or not
     *
     * @param bool $approved;
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     */
    public function setIsApproved($approved);
}
