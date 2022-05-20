<?php

namespace Sfedu\ShopsManage\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Locale\Bundle\DataBundle;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Sfedu\ShopsManage\Api\ReviewRepositoryInterface;
use Sfedu\ShopsManage\Model\Config\ShopConfig;

class ReviewList extends \Magento\Backend\Block\Template
{
    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * @var DataBundle
     */
    protected $dataBundle;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var ShopConfig
     */
    protected $config;

    /**
     * ShopInfo constructor
     *
     * @param ReviewRepositoryInterface $reviewRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        TimezoneInterface $timezone,
        DataBundle $dataBundle,
        ResolverInterface $localeResolver,
        ShopConfig $config,
        array $data = []
    ) {
        $this->timezone = $timezone;
        $this->dataBundle = $dataBundle;
        $this->locale = $localeResolver->getLocale();
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * Get fetch data url
     *
     * @return string
     */
    public function getDataSourcePath()
    {
        return $this->getBaseUrl() . $this->getFetchUrl();
    }

    /**
     * Get shop id
     *
     * @return int
     */
    public function getShopId()
    {
        return $this->getRequest()->getParam('id');
    }

    /**
     * Get calendar config
     *
     * @return array
     */
    public function getCalendar()
    {
        $localeData = $this->dataBundle->get($this->locale);
        $monthsData = $localeData['calendar']['gregorian']['monthNames'];
        $months = array_values(iterator_to_array($monthsData['format']['wide']));
        $monthsShort = array_values(
            iterator_to_array(
                null !== $monthsData->get('format')->get('abbreviated')
                    ? $monthsData['format']['abbreviated']
                    : $monthsData['format']['wide']
            )
        );
        return [
            'months' => $months,
            'monthsShort' => $monthsShort,
        ];
    }

    /**
     * Get config data
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            "component" => $this->getComponent(),
            "template" => $this->getXtemplate(),
            "fetchUrl" => $this->getDataSourcePath(),
            "scopeId" => $this->getShopId(),
            "defaultPageSize" => $this->config->getReviewsPageSize(),
            "storeLocale" => $this->locale,
            "storeTimezone" => $this->timezone->getConfigTimezone(),
            "calendarConfig" => $this->getCalendar(),
        ];
    }
}
