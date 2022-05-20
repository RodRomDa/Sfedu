<?php

namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Exception;
use Magento\Backend\App\Action\Context;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;

/**
 * MassDelete action
 *
 * Process mass delete of shops
 */
class MassDelete extends AbstractController
{

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * @param Context $context
     * @param ShopRepositoryInterface $shop
     */
    public function __construct(
        Context $context,
        ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
        $this->shopRepository = $shopRepository;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $selectedIds = $this->getRequest()->getParams()['selected'];
        if (!is_array($selectedIds)) {
            $this->messageManager->addErrorMessage(__('Please select one or more shop.'));
        } else {
            try {
                $collectionSize = count($selectedIds);
                foreach ($selectedIds as $shop_id) {
                    $this->shopRepository->deleteById($shop_id);
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
