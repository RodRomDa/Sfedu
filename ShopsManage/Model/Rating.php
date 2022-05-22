<?php


namespace Sfedu\ShopsManage\Model;


use Magento\Framework\Model\AbstractModel;
use Sfedu\ShopsManage\Api\Data\RatingInterface;

/**
 * Rating Model
 *
 * Represents rating of shop
 */
class Rating extends AbstractModel implements RatingInterface
{

    protected function _construct()
    {
        $this->_init(\Sfedu\ShopsManage\Model\ResourceModel\Rating::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::RATING_ID);
    }

    /**
     * Get ID
     *
     * @return String|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get ID
     *
     * @return String|null
     */
    public function getStarsNum()
    {
        return $this->getData(self::STARS_NUM);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return RatingInterface
     */
    public function setId($id)
    {
        return $this->setData(self::RATING_ID, $id);
    }

    /**
     * Set name
     *
     * @param String $name
     * @return RatingInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**s
     * Set starts number
     *
     * @param int $num
     * @return RatingInterface
     */
    public function setStarsNum($num)
    {
        return $this->setData(self::STARS_NUM, $num);
    }
}
