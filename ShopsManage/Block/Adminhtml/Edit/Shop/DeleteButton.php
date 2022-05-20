<?php
namespace Sfedu\ShopsManage\Block\Adminhtml\Edit\Shop;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Block\Adminhtml\Edit\GenericButton;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * Shop repository
     *
     * @var \Sfedu\ShopsManage\Api\ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Sfedu\ShopsManage\Api\ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        Context $context,
        ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
        $this->shopRepository = $shopRepository;
    }
    /**
     * Get necessary data for rendering
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this shop ?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Get URL for delete action
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getId()]);
    }

    /**
     * Return the shop id
     *
     * @return int|null
     */
    public function getId()
    {
        try {
            return $this->shopRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }
}
