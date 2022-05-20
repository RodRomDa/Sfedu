<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Rating;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Sfedu\ShopsManage\Api\Data\RatingInterface;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Sfedu_ShopsManage::rating';

    /**
     * @var \Sfedu\ShopsManage\Api\RatingRepositoryInterface
     */
    protected $ratingRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param RatingRepositoryInterface $ratingRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        RatingRepositoryInterface $ratingRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->ratingRepository = $ratingRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $ratingId) {
                    /** @var \Sfedu\ShopsManage\Api\Data\RatingInterface $rating */
                    $rating = $this->ratingRepository->getById($ratingId);
                    try {
                        $rating->setData(array_merge($rating->getData(), $postItems[$ratingId]));
                        $this->ratingRepository->save($rating);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithRatingId(
                            $rating,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add rating id to error message
     *
     * @param RatingInterface $rating
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithBlockId(BlockInterface $rating, $errorText)
    {
        return '[Rating ID: ' . $rating->getId() . '] ' . $errorText;
    }
}
