<?php


namespace Sfedu\ShopsManage\Api\Data;


interface RatingInterface
{
    /**
     * Constants for keys of data array.
     */
    const RATING_ID      = 'rating_id';
    const NAME         = 'name';
    const STARS_NUM    = 'stars_num';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Get stars number
     *
     * @return int|null
     */
    public function getStarsNum();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param String $name
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     */
    public function setName($name);

    /**
     * Set starts number
     *
     * @param int $num
     * @return \Sfedu\ShopsManage\Api\Data\RatingInterface
     */
    public function setStarsNum($num);
}
