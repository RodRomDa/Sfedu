<?php

namespace Sfedu\ShopsManage\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;

/**
 * ShopInfo block
 */
class ShopInfo extends \Magento\Framework\View\Element\Template implements IdentityInterface
{
    /**
     * Shop repository for retrieving necessary shop
     *
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * FilterProvider for processing content of wysiwig
     *
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $contentProcessor;

    /**
     * Json serializer for serializing product conditions
     *
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    protected $json;

    /**
     * ShopInfo constructor
     *
     * @param ShopRepositoryInterface $shopRepository
     * @param \Magento\Cms\Model\Template\FilterProvider $contentProcessor
     * @param \Magento\Framework\Serialize\SerializerInterface $json
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        ShopRepositoryInterface $shopRepository,
        \Magento\Cms\Model\Template\FilterProvider $contentProcessor,
        \Magento\Framework\Serialize\SerializerInterface $json,
        Template\Context $context,
        array $data = []
    ) {
        $this->json = $json;
        $this->shopRepository = $shopRepository;
        $this->contentProcessor = $contentProcessor;
        parent::__construct($context, $data);
    }

    /**
     * Do necessary actions before
     * rendering template
     *
     * @return ShopInfo
     */
    public function _prepareLayout()
    {
        $this->prepareProducts();
        $this->setMeta();
        return parent::_prepareLayout();
    }

    /**
     * Set products in product widget
     */
    public function prepareProducts()
    {
        /** @var \Magento\CatalogWidget\Block\Product\ProductsList $productList */
        $productList = $this->getChildBlock('catalog.products');
        $productList->setTitle(__('Shop typical products'));
        $productList->setConditions($this->getProductConditions());
    }

    /**
     * Return serilaized conditions
     * for rendering products in widget
     *
     * @return string
     */
    protected function getProductConditions()
    {
        $productIds = $this->getShop()->getProductIds();
        $settings = [
            '1' => [
                'type' => 'Magento\CatalogWidget\Model\Rule\Condition\Combine',
                'aggregator' => 'all',
                'value' => '1',
                'new_child' => '',
            ],
            '1--1' => [
                'type' => 'Magento\CatalogWidget\Model\Rule\Condition\Product',
                'attribute' => 'e.entity_id',
                'operator' => '()',
                'value' => implode(',', $productIds)
            ]
        ];
        return $this->json->serialize($settings);
    }

    /**
     * Set meta information for the page
     */
    public function setMeta()
    {
        $shop = $this->getShop();
        $meta = $shop->getMeta();
        if ($shop->hasData(ShopInterface::META_TITLE)) {
            $this->pageConfig->setMetaTitle($meta[ShopInterface::META_TITLE]);
            $this->pageConfig->getTitle()->set($meta[ShopInterface::META_TITLE]);
        }
        if ($shop->hasData(ShopInterface::META_DESCR)) {
            $this->pageConfig->setDescription($meta[ShopInterface::META_DESCR]);
        }
        if ($shop->hasData(ShopInterface::META_KEYS)) {
            $this->pageConfig->setKeywords($meta[ShopInterface::META_KEYS]);
        }
    }

    /**
     * Helper method to process wysiwig content
     *
     * @param string $content
     * @return string
     */
    public function processContent($content)
    {
        return $this->contentProcessor->getPageFilter()->filter($content);
    }

    /**
     * Get shop instance
     *
     * @return ShopInterface
     */
    public function getShop()
    {
        $id = $this->getRequest()->getParam('id');
        $shop = $this->shopRepository->getById($id);
        return $shop;
    }

    /**
     * Return identifiers for shop content data
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return $this->getShop()->getIdentities();
    }
}
