<?php

namespace Sfedu\ShopsManage\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ShopConfig
{

    /**
     * @var ScopeConfigInterface
     */
    protected $config;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct(
        ScopeConfigInterface $config,
        SerializerInterface $serializer
    ) {
        $this->config = $config;
        $this->serializer = $serializer;
    }

    /**
     * Get towns config options
     *
     * @return string[]
     */
    public function getTowns()
    {
        $towns = $this->config->getValue(
            'shopsmanage/general/shop_towns',
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
        );

        if(!is_array($towns)) {
            $towns = $this->serializer->unserialize($towns);
        }
        $towns = array_map(function ($town) { return $town['town']; }, $towns);
        return $towns;
    }

    /**
     * Get shops page size config
     *
     * @return int
     */
    public function getShopsPageSize()
    {
        return (int) $this->config->getValue(
            'shopsmanage/general/shop_page_count',
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get if is allowed to change shops page size
     *
     * @return bool
     */
    public function getIsAllowPageChange()
    {
        return (bool) $this->config->getValue(
            'shopsmanage/general/shop_page_change',
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * Get reviews page size config
     *
     * @return int
     */
    public function getReviewsPageSize()
    {
        return (int) $this->config->getValue(
            'shopsmanage/general/review_page_count',
            \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE
        );
    }
}
