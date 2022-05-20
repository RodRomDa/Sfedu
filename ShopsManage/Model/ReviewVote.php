<?php

namespace Sfedu\ShopsManage\Model;

use Sfedu\ShopsManage\Api\Data\RatingInterface;
use Sfedu\ShopsManage\Api\Data\RatingVoteInterface;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;

class ReviewVote extends \Magento\Framework\DataObject implements RatingVoteInterface
{
    /**
     * @var RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * ReviewVote constructor.
     * @param array $data
     */
    public function __construct(
        RatingRepositoryInterface $ratingRepository,
        array $data = []
    ) {
        $this->ratingRepository = $ratingRepository;
        parent::__construct($data);
    }

    /**
     * Get rating
     *
     * @return RatingInterface
     */
    public function getRating()
    {
        $ratingId = $this->getRatingId();

        return $this->ratingRepository->getById($ratingId);
    }

    /**
     * Get rating id
     *
     * @return int
     */
    public function getRatingId()
    {
        return (int)$this->getData(self::RATING_ID);
    }

    /**
     * Get rating score
     *
     * @return int
     */
    public function getValue()
    {
        return (int)$this->getData(self::VALUE);
    }

    /**
     * Get rating id
     *
     * @param  int $ratingId
     * @return RatingVoteInterface
     */
    public function setRatingId($ratingId)
    {
        return $this->setData(self::RATING_ID, $ratingId);
    }

    /**
     * Set value
     *
     * @param  int $ratingId
     * @return RatingVoteInterface
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }
}
