<?php


namespace Sfedu\ShopsManage\Api\Data;


interface RatingVoteInterface
{
    /**
     * Constants for keys of data array.
     */
    const ID = 'entity_id';
    const RATING_ID      = 'rating_id';
    const VALUE         = 'value';
    const REVIEW_ID         = 'review_id';

    /**
     * Get rating
     *
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     */
    public function getRating();

    /**
     * Get rating id
     *
     * @return int
     */
    public function getRatingId();

    /**
     * Get rating score
     *
     * @return int
     */
    public function getValue();

    /**
     * Get rating id
     *
     * @param  int $ratingId
     * @return \Sfedu\ShopsManage\Api\Data\RatingVoteInterface
     */
    public function setRatingId($ratingId);

    /**
     * Set value
     *
     * @param  int $ratingId
     * @return \Sfedu\ShopsManage\Api\Data\RatingVoteInterface
     */
    public function setValue($value);
}
