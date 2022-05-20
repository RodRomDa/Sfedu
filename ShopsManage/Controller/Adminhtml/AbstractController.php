<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml;

/**
 * Class ShopController
 *
 * Abstract base class for admin actions with shops
 */
abstract class AbstractController extends \Magento\Backend\App\Action
{
    const MENU_ITEM = 'Sfedu_ShopsManage::shops';
    const ADMIN_RESOURCE = 'Sfedu_ShopsManage::shops';

    /**
     * Title for page
     *
     * @var string $pageTitle
     */
    protected string $pageTitle = 'Shops';

    /**
     * Init page
     *
     * @param \Magento\Framework\View\Result\Page $resultPage
     * @return \Magento\Framework\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu(self::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend(__($this->pageTitle));
        return $resultPage;
    }

    /**
     * Set title of page
     *
     * @param string $title
     */
    protected function setTitle($title)
    {
        $this->pageTitle = $title;
    }
}
