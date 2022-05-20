<?php

namespace Sfedu\ShopsManage\Controller\Index;

use Magento\Framework\UrlInterface;
use Sfedu\ShopsManage\Controller\ShopController;

/**
 * Index actions
 *
 * Renders list of all shops
 */
class Index extends ShopController
{
    /**
     * @var  \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor
     *
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($urlBuilder);
    }

    /**
     * Shop Index, shows a list of all active shops.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Shops List'));
        $this->setBreadCrumbs($resultPage, [
            [
                'name' => 'sfedu_shops',
                'label' => 'Shops'
            ]
        ]);
        return $resultPage;
    }
}
