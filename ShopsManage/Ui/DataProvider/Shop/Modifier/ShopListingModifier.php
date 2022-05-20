<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Shop\Modifier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Sfedu\ShopsManage\Model\Config\ShopConfig;

/**
 * Modifies listing in frontend
 * adds page size setting
 */
class ShopListingModifier implements ModifierInterface
{
    /**
     * Core store config
     *
     * @var ShopConfig
     */
    private $config;

    /**
     * ListingModifier constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ShopConfig $config
    ) {
        $this->config = $config;
    }

    /**
     * Meta modifier
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $meta['listing_paging'] = [
                    'arguments' => [
                        'sortOrder' => 50,
                        'data' => [
                            'config' => [
                                'componentType' => 'paging',
                                'pageSize' => $this->config->getShopsPageSize(),
                                //'totalTmpl' => 'Sfedu_ShopsManage/empty',
                                'sizesConfig' => [
                                    'template' => $this->config->getIsAllowPageChange() ?
                                        'Sfedu_ShopsManage/paging/sizes' :
                                        'Sfedu_ShopsManage/empty',
                                ],
                                'options' => [
                                    '10' => [
                                        'value' => 10,
                                        'label' => 10
                                    ],
                                    '20' => [
                                        'value' => 20,
                                        'label' => 20
                                    ]
                                ]
                            ]
                        ]
                    ]
                ];

        return $meta;
    }

    /**
     * Data modifier
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}
