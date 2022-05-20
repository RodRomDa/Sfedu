<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Rating;


class Delete extends \Magento\Backend\App\Action
{

    /**
     * @var \Sfedu\ShopsManage\Api\RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * Delete constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Sfedu\ShopsManage\Api\RatingRepositoryInterface $ratingRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Sfedu\ShopsManage\Api\RatingRepositoryInterface $ratingRepository
    ) {
        $this->ratingRepository = $ratingRepository;
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
            $rating = $this->ratingRepository->getById($id);
            $this->ratingRepository->delete($rating);
            $this->messageManager->addSuccessMessage(__('Rating has been deleted'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete shop'));
        }

        return $resultRedirect->setPath('*/*/index');
    }

}
