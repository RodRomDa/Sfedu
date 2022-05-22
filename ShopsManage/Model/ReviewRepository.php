<?php

namespace Sfedu\ShopsManage\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Sfedu\ShopsManage\Api\Data\ReviewInterface;
use Sfedu\ShopsManage\Api\Data\ReviewPageInterfaceFactory;
use Sfedu\ShopsManage\Api\ReviewRepositoryInterface;
use Sfedu\ShopsManage\Model\ResourceModel\Review\CollectionFactory as ReviewCollectionFactory;
use Sfedu\ShopsManage\Model\ResourceModel\Review\Collection as ReviewCollection;

/**
 * Review Repository
 *
 * Provides service to retrieve and save shop reviews and their ratings
 */
class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * @var ReviewFactory
     */
    protected $reviewFactory;

    /**
     * @var ReviewCollection
     */
    protected $reviewCollection;

    /**
     * @var ReviewPageInterfaceFactory
     */
    protected $reviewPageFactory;

    /**
     * ReviewRepository constructor.
     *
     * @param \Sfedu\ShopsManage\Model\ReviewFactory $reviewFactory
     * @param ReviewCollectionFactory $reviewCollectionFactory
     * @param ReviewPageInterfaceFactory $reviewPageFactory
     */
    public function __construct(
        ReviewFactory $reviewFactory,
        ReviewCollectionFactory $reviewCollectionFactory,
        ReviewPageInterfaceFactory $reviewPageFactory
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->reviewCollection = $reviewCollectionFactory->create();
        $this->reviewPageFactory = $reviewPageFactory;
    }

    /**
     * Retrieve review
     *
     * @param int $id
     * @return ReviewInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $review = $this->reviewFactory->create();
        $this->reviewCollection->getResource()->load($review, $id);
        if (! $review->getId()) {
            throw new NoSuchEntityException(__('Unable to find review with ID "%1"', $id));
        }
        return $review;
    }

    /**
     * Retrieve reviews by shop
     *
     * @param int $shopId
     * @param int $page
     * @param int $pageSize
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getShopReviewsPage($shopId, $page, $pageSize=10)
    {
        $review = $this->reviewFactory->create();
        $this->reviewCollection
             ->addFilter(ReviewInterface::SHOP_ID, $shopId)
             ->addOrder(ReviewInterface::CREATED_AT)
             ->setPageSize($pageSize)
             ->setCurPage($page);

        $pageResult = $this->reviewPageFactory->create();
        $pageResult->setItems($this->reviewCollection->getItems());
        $pageResult->setTotalCount($this->reviewCollection->getSize());

        return $pageResult;
    }

    /**
     * Retrieve approved reviews by shop
     *
     * @param int $shopId
     * @param int $page
     * @param int $pageSize
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getShopReviewsApprovedPage($shopId, $page, $pageSize=10)
    {
        $review = $this->reviewFactory->create();
        $this->reviewCollection
            ->addFilter(ReviewInterface::SHOP_ID, $shopId)
            ->addFilter(ReviewInterface::IS_APPROVED, true)
            ->addOrder(ReviewInterface::CREATED_AT)
            ->setPageSize($pageSize)
            ->setCurPage($page);

        $pageResult = $this->reviewPageFactory->create();
        $pageResult->setItems($this->reviewCollection->getItems());
        $pageResult->setTotalCount($this->reviewCollection->getSize());

        return $pageResult;
    }

    /**
     * Retrieve page of reviews by shop
     *
     * @param int $reviewId
     * @param bool $approved
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function setReviewApproved($reviewId, $approved)
    {
        $review = $this->getById($reviewId);
        $review->setIsApproved($approved);
        $this->reviewCollection->getResource()->save($review);
        return $approved;
    }

    /**
     * Save review
     *
     * @param ReviewInterface $review
     * @return ReviewInterface
     */
    public function save(ReviewInterface $review)
    {
        $this->reviewCollection->getResource()->save($review);
        return $review;
    }

    /**
     * Delete review
     *
     * @param ReviewInterface
     * @return bool true on success
     */
    public function delete(ReviewInterface $review)
    {
        $this->reviewCollection->getResource()->delete($review);
    }
}
