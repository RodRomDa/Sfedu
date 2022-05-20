<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Rating;


use Magento\Framework\Controller\ResultFactory;

class NewAction extends \Magento\Backend\App\Action
{
    const MENU_ITEM = 'Sfedu_ShopsManage::rating';
    const ADMIN_RESOURCE = 'Sfedu_ShopsManage::rating';


    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Render rating new page
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(self::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend(__('New Rating'));
        return $resultPage;
    }
}
