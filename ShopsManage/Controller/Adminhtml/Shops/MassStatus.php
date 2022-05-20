<?php

namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;
use Sfedu\ShopsManage\Model\ShopRepository;

/**
 * MassStatus Actions
 *
 * Process mass change status of shops
 */
class MassStatus extends AbstractController
{

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * @param Context $context
     * @param ShopRepositoryInterface $shopRepository
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
        $status = $this->getRequest()->getParams()['status'];
        if (!is_array($selectedIds)) {
            $this->messageManager->addErrorMessage(__('Please select one or more shop.'));
        } else {
            try {
                $collectionSize = count($selectedIds);
                foreach ($selectedIds as $shop_ids) {
                    $shop = $this->shopRepository->getById($shop_ids);
                    $shop->setIsActive($status);
                    $this->shopRepository->save($shop);
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have status changed.', $collectionSize));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
