<?php
namespace Sfedu\ShopsManage\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Search\Controller\RegistryConstants;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;

/**
 * Class GenericButton
 *
 * Basic class of form buttons of this module
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;


    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
