<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Review;


use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    const MENU_ITEM = 'Sfedu_ShopsManage::shops_reviews';
    const ADMIN_RESOURCE = 'Sfedu_ShopsManage::shops_reviews';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Render rating page
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(self::MENU_ITEM);
        $resultPage->getConfig()->getTitle()->prepend(__('Shops Reviews Stats'));
        return $resultPage;
    }
}
