<?php

namespace Sfedu\ShopsManage\Api;

use Sfedu\ShopsManage\Api\Data\RatingInterface;

/**
 * RatingRepository interface
 * @api
 */
interface RatingRepositoryInterface
{
    /**
     * Save rating
     *
     * @param RatingInterface
     * @return RatingInterface
     */
    public function save(RatingInterface $rating);

    /**
     * Delete rating
     *
     * @param RatingInterface
     * @return bool true on success
     */
    public function delete(RatingInterface $rating);

    /**
     * Retrieve rating
     *
     * @param int $ratingId
     * @return RatingInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($ratingId);

    /**
     * Get all ratings
     *
     * @return RatingInterface[]
     */
    public function getAll();
}
