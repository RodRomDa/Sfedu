<?php
namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Magento\Framework\App\Request\DataPersistorInterface;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;

/**
 * Edit action
 *
 * Process edit shop action
 */
class Edit extends AbstractController
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersitor;

    /**
     * Edit constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        DataPersistorInterface $dataPersistor
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersitor = $dataPersistor;
        parent::__construct($context);
        $this->setTitle(__('Shop Edit'));
    }

    /**
     * Process edit action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->dataPersitor->set('shopsmanage_shop_edit_id', $this->getRequest()->getParam('id'));
        return $this->initPage($this->resultPageFactory->create());
    }
}
