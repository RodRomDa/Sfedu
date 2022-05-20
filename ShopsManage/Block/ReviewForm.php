<?php

namespace Sfedu\ShopsManage\Block;

use Magento\Customer\Model\Context;
use Sfedu\ShopsManage\Api\Data\RatingInterface;
use Sfedu\ShopsManage\Api\RatingRepositoryInterface;
use Magento\Customer\Model\Url;

class ReviewForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * @var \Magento\Framework\Url\EncoderInterface
     */
    protected $urlEncoder;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * @var \Sfedu\ShopsManage\Api\RatingRepositoryInterface;
     */
    protected $ratingRepository;

    /**
     * Form construct
     *
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param RatingRepositoryInterface $ratingRepository
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Customer\Model\Url $customerUrl,
        RatingRepositoryInterface $ratingRepository,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->httpContext = $httpContext;
        $this->urlEncoder = $urlEncoder;
        $this->customerUrl = $customerUrl;
        $this->ratingRepository = $ratingRepository;
        parent::__construct($context, $data);
    }

    /**
     * Initialize review form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setAllowWriteReviewFlag(
            $this->httpContext->getValue(Context::CONTEXT_AUTH)
        );
        if (!$this->getAllowWriteReviewFlag()) {
            $queryParam = $this->urlEncoder->encode(
                $this->getUrl('*/*/*', ['_current' => true]) . '#review-form'
            );
            $this->setLoginLink(
                $this->getUrl(
                    'customer/account/login/',
                    [Url::REFERER_QUERY_PARAM_NAME => $queryParam]
                )
            );
        }
    }

    /**
     * Get form action URL for POST review request
     *
     * @return string
     */
    public function getAction()
    {
        return $this->getUrl(
            'shops/shop/review',
            [
                '_secure' => $this->getRequest()->isSecure(),
                'id' => $this->getShopId(),
            ]
        );
    }

    /**
     * Get collection of ratings
     *
     * @return RatingInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRatings()
    {
        return $this->ratingRepository->getAll();
    }
    /**
     * Return register URL
     *
     * @return string
     */
    public function getRegisterUrl()
    {
        return $this->customerUrl->getRegisterUrl();
    }

    /**
     * Get review shop id
     *
     * @return int
     */
    protected function getShopId()
    {
        return $this->getRequest()->getParam('id', false);
    }

}
