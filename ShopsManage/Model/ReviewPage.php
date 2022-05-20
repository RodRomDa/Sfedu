<?php


namespace Sfedu\ShopsManage\Model;


use Sfedu\ShopsManage\Api\Data\ReviewPageInterface;

class ReviewPage extends \Magento\Framework\DataObject implements ReviewPageInterface
{

    /**
     * Get items list.
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewInterface[]
     */
    public function getReviews()
    {
        return $this->getData(self::KEY_ITEMS);
    }

    /**
     * Get total count of reviews.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->getData(self::KEY_COUNT);
    }

    /**
     * Set review list.
     *
     * @param \Sfedu\ShopsManage\Api\Data\ReviewInterface[] $reviews
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     */
    public function setReviews($reviews)
    {
        return $this->setData(self::KEY_ITEMS, $reviews);
    }

    /**
     * Set total count of reviews.
     *
     * @param int $count
     *
     * @return \Sfedu\ShopsManage\Api\Data\ReviewPageInterface
     */
    public function setCount($count)
    {
        return $this->setData(self::KEY_COUNT, $count);
    }
}
