<?php

namespace Sfedu\ShopsManage\Controller;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Class ShopController
 *
 * Abstract base class for frontend actions with shops
 */
abstract class ShopController implements HttpGetActionInterface
{

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * ShopController constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Sets breadcrumbs to page
     *
     * the $crumbs array should have the following format
     *
     * [ ['name' => ..., 'label'=> ..., 'path' => ...], ... ]
     *
     * By default sets home crumb
     *
     * @param \Magento\Framework\View\Result\Page $resultPage
     * @param array $crumbs
     */
    protected function setBreadCrumbs($resultPage, $crumbs)
    {
        /** @var \Magento\Theme\Block\Html\Breadcrumbs $breadcrumbs */
        $breadcrumbs = $resultPage->getLayout()->getBlock('breadcrumbs');

        $breadcrumbs->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Home'),
                'link' => $this->urlBuilder->getUrl('')
            ]
        );

        foreach ($crumbs as $crumb) {
            $breadcrumbs->addCrumb(
                $crumb['name'],
                [
                    'label' => __($crumb['label']),
                    'title' => __($crumb['label']),
                    'link' => isset($crumb['path']) ? $this->urlBuilder->getUrl($crumb['path']) : null
                ]
            );
        }
    }
}
