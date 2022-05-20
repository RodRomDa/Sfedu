<?php


namespace Sfedu\ShopsManage\Controller\Adminhtml\Review;


use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;

class View extends \Magento\Backend\App\Action
{
    const MENU_ITEM = 'Sfedu_ShopsManage::shops_reviews';
    const ADMIN_RESOURCE = 'Sfedu_ShopsManage::shops_reviews';

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory = false;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->shopRepository = $shopRepository;
        parent::__construct($context);
    }

    /**
     * Render shop reviews page
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $shop = $this->shopRepository->getById($id);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(self::MENU_ITEM);
        $title = __('Reviews of %1', $shop->getTitle());
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
