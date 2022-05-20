<?php
namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Magento\Framework\View\Result\PageFactory;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;
use Sfedu\ShopsManage\Model\ShopFactory;

/**
 * Delete action
 *
 * Process delete shop action
 */
class Delete extends AbstractController
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ShopFactory
     */
    protected $shopFactory;

    /**
     * @var \Sfedu\ShopsManage\Api\ShopRepositoryInterface
     */
    protected $shopRepository;


    /**
     * Delete constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Sfedu\ShopsManage\Api\ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Sfedu\ShopsManage\Api\ShopRepositoryInterface $shopRepository
    ) {
        $this->shopRepository = $shopRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');

        try {
            $shop = $this->shopRepository->getById($id);
            $this->shopRepository->delete($shop);
            $this->messageManager->addSuccessMessage(__('Shop has been deleted'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete shop'));
            return $resultRedirect->setPath('*/*/index');
        }

        return $resultRedirect->setPath('*/*/index');
    }
}
