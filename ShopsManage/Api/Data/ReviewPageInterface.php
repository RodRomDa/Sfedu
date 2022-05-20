<?php

namespace Sfedu\ShopsManage\Api\Data;

interface ReviewPageInterface
{
    const KEY_ITEMS = 'items';
    const KEY_COUNT = 'total_count';

    /**
     * Get review list.
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface[]
     */
    public function getReviews();

    /**
     * Get total count of reviews.
     *
     * @return int
     */
    public function getCount();

    /**
     * Set review list.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ReviewInterface[] $reviews
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     */
    public function setReviews($reviews);

    /**
     * Set total count of reviews.
     *
     * @param int $count
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     */
    public function setCount($count);
}
