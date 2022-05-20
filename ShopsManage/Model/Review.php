<?php

namespace Sfedu\ShopsManage\Model;

use Magento\Framework\Model\AbstractModel;
use Sfedu\ShopsManage\Api\Data\RatingVoteInterface;
use Sfedu\ShopsManage\Api\Data\ReviewInterface;

class Review extends AbstractModel implements ReviewInterface
{
    /**
     * @var  ResourceModel\ReviewVote\CollectionFactory
     */
    protected $voteCollectionFactory;

    /**
     * @var  ReviewVoteFactory
     */
    protected $voteFactory;

    /**
     * Shop constructor
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param ResourceModel\ReviewVote\CollectionFactory $voteCollectionFactory
     * @param ReviewVoteFactory $reviewVoteFactory
     * @param array $data
     */

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        ResourceModel\ReviewVote\CollectionFactory $voteCollectionFactory,
        ReviewVoteFactory $reviewVoteFactory,
        array $data = []
    ) {
        $this->voteCollectionFactory = $voteCollectionFactory;
        $this->voteFactory = $reviewVoteFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\ResourceModel\Review::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::REVIEW_ID);
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
     * Get detail
     *
     * @return string|null
     */
    public function getDetail()
    {
        return $this->getData(self::DETAIL);
    }

    /**
     * Get nickname
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->getData(self::NICKNAME);
    }

    /**
     * Get reviewed shop id
     *
     * @return int|null
     */
    public function getShopId()
    {
        return $this->getData(self::SHOP_ID);
    }

    /**
     * Get customer id of review
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Get review creation date
     *
     * @return string|null
     */
    public function getCreationDate()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get review is approved or not
     *
     * @return bool
     */
    public function getIsApproved()
    {
        return $this->getData(self::IS_APPROVED);
    }

    /**
     * Get review ratings
     *
     * @return RatingVoteInterface[]
     */
    public function getRatings()
    {
        if (!$this->getId()) {
            return [];
        }

        $array = $this->getData('loaded_ratings');
        if ($array === null) {
            $collection = $this->voteCollectionFactory->create();
            $array = $collection->setReviewFilter($this->getId())
                                ->setRatingSortOrder()
                                ->getItems();
            $this->setData('loaded_ratings', $array);
        }
        return $array;
    }

    /**
     * Set review ratings
     *
     * @param array $ratings
     * @return ReviewInterface
     */
    public function setRatings($ratings)
    {
        $reviewRatings = [];
        foreach ($ratings as $key => $val) {
            $ratingVote = $this->voteFactory->create();
            $ratingVote->setRatingId($key);
            $ratingVote->setValue($val);
            $reviewRatings[] = $ratingVote;
        }
        return $this->setData('loaded_ratings', $reviewRatings);
    }

    /**
     * Set customer id of review
     *
     * @param int $customerId
     * @return ReviewInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Set shop id of review
     *
     * @param int $shopId
     * @return ReviewInterface
     */
    public function setShopId($shopId)
    {
        return $this->setData(self::SHOP_ID, $shopId);
    }

    /**
     * Set review is approved or not
     *
     * @param bool $approved;
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface
     */
    public function setIsApproved($approved)
    {
        return $this->setData(self::IS_APPROVED, $approved);
    }

    /**
     * Validate review summary fields
     *
     * @return bool|string[]
     */
    public function validate()
    {
        $errors = [];

        if (!\Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = __('Please enter a review summary.');
        }

        if (!\Zend_Validate::is($this->getNickname(), 'NotEmpty')) {
            $errors[] = __('Please enter a nickname.');
        }

        if (!\Zend_Validate::is($this->getDetail(), 'NotEmpty')) {
            $errors[] = __('Please enter a review.');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }
}
