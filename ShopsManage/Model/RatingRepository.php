<?php

namespace Sfedu\ShopsManage\Model;

use Sfedu\ShopsManage\Api\Data\RatingInterface;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;
use Sfedu\ShopsManage\Model\ResourceModel\Rating\Collection as RatingCollection;
use Sfedu\ShopsManage\Model\ResourceModel\Rating\CollectionFactory as RatingCollectionFactory;

class RatingRepository implements RatingRepositoryInterface
{

    /**
     * @var RatingFactory
     */
    protected $ratingFactory;

    /**
     * @var RatingCollection
     */
    protected $ratingCollection;

    /**
     * RatingRepository constructor.
     *
     * @param \Sfedu\ShopsManage\Model\RatingFactory $ratingFactory
     * @param RatingCollectionFactory $ratingCollectionFactory
     */
    public function __construct(
        RatingFactory $ratingFactory,
        RatingCollectionFactory $ratingCollectionFactory
    ) {
        $this->ratingFactory = $ratingFactory;
        $this->ratingCollection = $ratingCollectionFactory->create();
    }

    /**
     * Retrieve rating.
     *
     * @param int $id
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $rating = $this->ratingFactory->create();
        $this->ratingCollection->getResource()->load($rating, $id);
        if (! $rating->getId()) {
            throw new NoSuchEntityException(__('Unable to find rating with ID "%1"', $id));
        }
        return $rating;
    }

    /**
     * Save rating.
     *
     * @param \Sfedu\ShopsManage\Api\Data\RatingInterface $rating
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     */
    public function save(RatingInterface $rating)
    {
        $this->ratingCollection->getResource()->save($rating);
        return $rating;
    }

    /**
     * Delete rating
     *
     * @param RatingInterface
     * @return bool true on success
     */
    public function delete(RatingInterface $rating) {
        $this->ratingCollection->getResource()->delete($rating);
    }

    /**
     * Get all ratings
     *
     * @return RatingInterface[]
     */
    public function getAll()
    {
        return $this->ratingCollection->setOrder(RatingInterface::NAME, 'ASC')->getItems();
    }
}
