<?php
namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;

/**
 * Index action
 *
 * Render shop grid
 */
class Index extends AbstractController implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Render shops page
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        return $this->initPage($this->resultPageFactory->create());
    }
}
