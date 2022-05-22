<?php


namespace Sfedu\ShopsManage\Api;

/**
 * ReviewRepository interface
 * @api
 * Provides service to retrieve and save shop reviews and their ratings
 */
interface ReviewRepositoryInterface
{
    /**
     * Save rating
     *
     * @param \Sfedu\ShopsManage\Api\Data\ReviewInterface
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     */
    public function save(\Sfedu\ShopsManage\Api\Data\ReviewInterface $review);

    /**
     * Delete rating
     *
     * @param \Sfedu\ShopsManage\Api\Data\ReviewInterface
     * @return bool true on success
     */
    public function delete(\Sfedu\ShopsManage\Api\Data\ReviewInterface $review);

    /**
     * Retrieve review
     *
     * @param int $id
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Retrieve page of reviews by shop
     *
     * @param int $shopId
     * @param int $page
     * @param int $pageSize
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getShopReviewsPage($shopId, $page, $pageSize=10);

    /**
     * Retrieve page of reviews by shop
     *
     * @param int $shopId
     * @param int $page
     * @param int $pageSize
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getShopReviewsApprovedPage($shopId, $page, $pageSize=10);

    /**
     * Retrieve page of reviews by shop
     *
     * @param int $reviewId
     * @param bool $approved
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function setReviewApproved($reviewId, $approved);
}
