<?php

namespace Sfedu\ShopsManage\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;
use Sfedu\ShopsManage\Model\Shop;

/**
 * Plugin NonCategoryLink
 *
 * Renders "Shops" menu item in frontend
 */
class NonCategoryLink
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * NonCategoryLink constructor
     *
     * @param NodeFactory $nodeFactory
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        NodeFactory $nodeFactory,
        UrlInterface $urlBuilder
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Intercept method to add menu item
     *
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray($subject),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    /**
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @return array
     */
    protected function getNodeAsArray($subject)
    {
        return [
            'name' => __('Shops'),
            'id' => 'shopsmanage-shop-link',
            'url' => $subject->getUrl('shops'),
            'has_active' => false,
            'is_active' => $this->isActive($subject->getRequest()->getModuleName())
        ];
    }

    /**
     * Test if shop set menu item active
     *
     * @param $route
     * @return bool
     */
    protected function isActive($route)
    {
        return $route == 'shops';
    }
}
