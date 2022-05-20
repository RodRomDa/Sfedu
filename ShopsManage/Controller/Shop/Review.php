<?php

namespace Sfedu\ShopsManage\Controller\Shop;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Setup\Exception;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Api\ReviewRepositoryInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Model\ReviewFactory;

class Review implements HttpPostActionInterface
{
    /**
     * Redirect result
     *
     * @var   ResultFactory
     */
    protected $resultFactory;

    /**
     * Received request
     *
     * @var   RequestInterface
     */
    protected $request;

    /**
     * Message manager
     *
     * @var   MessageManagerInterface
     */
    protected $messageManager;

    /**
     * Review repository
     *
     * @var ReviewRepositoryInterface
     */
    protected $reviewRepository;

    /**
     * Review model
     *
     * @var ReviewFactory
     */
    protected $reviewFactory;

    /**
     * Shops repository
     *
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * Core form key validator
     *
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * Customer session model
     *
     * @var Session
     */
    protected $customerSession;

    /**
     * Index constructor
     *
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param MessageManagerInterface $messageManager
     * @param ReviewRepositoryInterface $reviewRepository
     * @param ReviewFactory $reviewFactory
     * @param ShopRepositoryInterface $shopRepository
     * @param Validator $formKeyValidator
     * @param Session $customerSession
     */
    public function __construct(
        ResultFactory $resultFactory,
        RequestInterface $request,
        MessageManagerInterface $messageManager,
        ReviewRepositoryInterface $reviewRepository,
        ReviewFactory $reviewFactory,
        ShopRepositoryInterface $shopRepository,
        Validator $formKeyValidator,
        Session $customerSession
    ) {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->reviewRepository = $reviewRepository;
        $this->reviewFactory = $reviewFactory;
        $this->shopRepository = $shopRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
    }

    /**
     * Post action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setRefererUrl();

        if (!$this->formKeyValidator->validate($this->request)) {
            return $resultRedirect;
        }

        $data = $this->request->getPostValue();
        $ratings = $this->request->getParam('ratings', []);

        if (($shop = $this->initShop()) && !empty($data)) {
            /** @var \Sfedu\ShopsManage\Model\Review */
            $review = $this->reviewFactory->create()->setData($data);
            $review->unsetData('review_id');

            $validate = $review->validate();
            if ($validate === true) {
                try {
                    $review->setShopId($shop->getId())
                           ->setCustomerId($this->customerSession->getCustomerId())
                           ->setRatings($ratings);
                    $this->reviewRepository->save($review);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('We can\'t receive your review right now.'));
                    return $resultRedirect;
                }
            }

            // Display the success form validation message
            $this->messageManager->addSuccessMessage(__('Thanks for the feedback! Your review will be considered.'));

            return $resultRedirect;
        }
    }

    /**
     * Initialize and check shop
     *
     * @return ShopInterface|bool
     */
    protected function initShop()
    {
        $shopId = (int)$this->request->getParam('id');
        if (!$shopId) {
            return false;
        }
        try {
            $shop = $this->shopRepository->getById($shopId);

            if (!$shop->isActive()) {
                throw new NoSuchEntityException();
            }
        } catch (Exception $e) {
            return false;
        }

        return $shop;
    }
}
