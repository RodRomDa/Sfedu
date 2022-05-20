<?php

namespace Sfedu\ShopsManage\Controller\Shop;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Controller\ShopController;

/**
 * Index action
 *
 * Render the page of one shop
 */
class Index extends ShopController
{
    /**
     * @var   ResultFactory
     */
    protected $resultFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Index constructor
     *
     * @param ResultFactory $resultFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResultFactory $resultFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager
    ) {
        $this->resultFactory = $resultFactory;
        $this->storeManager = $storeManager;
        parent::__construct($urlBuilder);
    }

    /**
     * Shop Index, shows a list of all active shops.
     *
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setRefererUrl();

        try {
            /** @var \Sfedu\ShopsManage\Block\ShopInfo $shopinfo */
            $shopinfo = $resultPage->getLayout()->getBlock('shopinfo');
            $shop = $shopinfo->getShop();
        } catch (NoSuchEntityException $e) {
            return $resultRedirect;
        }

        if ($this->isCorrectStore($shop)&&$shop->getId()) {
            $this->setBreadCrumbs($resultPage, [
                [
                    'name' => 'sfedu_shops',
                    'label' => 'Shops',
                    'path' => 'shops'
                ],
                [
                    'name'  => 'sfedu_shops_shop',
                    'label' => $shop->getTitle()
                ]
            ]);
            return $resultPage;
        } else {
            return $resultRedirect;
        }
    }

    /**
     * Test if shop is in correct scope view
     *
     * @param ShopInterface $shop
     * @return bool
     */
    protected function isCorrectStore($shop)
    {
        $curStore = $this->storeManager->getStore();
        return $shop->hasStore($curStore);
    }
}
