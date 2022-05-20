<?php
namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;

/**
 * Class NewAction
 *
 * Render form of new shop
 */
class NewAction extends AbstractController
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * NewAction constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->setTitle(__('New Shop'));
    }

    /**
     * Render new shop form
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $this->initPage($this->resultPageFactory->create());
    }
}
