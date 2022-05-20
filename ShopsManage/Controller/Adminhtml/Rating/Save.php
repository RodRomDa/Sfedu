<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Rating;


use Magento\Framework\Exception\LocalizedException;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;
use Sfedu\ShopsManage\Model\RatingFactory;

class Save  extends \Magento\Backend\App\Action
{

    /**
     * @var RatingFactory
     */
    protected $ratingFactory;

    /**
     * @var RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * Save constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param RatingRepositoryInterface $ratingRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        RatingFactory $ratingFactory,
        RatingRepositoryInterface $ratingRepository
    ) {
        $this->ratingFactory = $ratingFactory;
        $this->ratingRepository = $ratingRepository;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['rating_id'])) {
                $data['rating_id'] = null;
            }

            /** @var \Sfedu\ShopsManage\Api\Data\RatingInterface $rating */
            $rating = $this->ratingFactory->create();

            $rating->setData($data);


            try {
                $this->ratingRepository->save($rating);
                $this->messageManager->addSuccessMessage(__('You saved the rating.'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the shop.'));
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

}
