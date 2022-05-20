<?php


namespace Sfedu\ShopsManage\Controller\Index;

use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Controller\Adminhtml\AbstractAction;

/**
 * Class Render
 *
 * Handles ajax requests from ui-components in frontend
 */
class Render extends AbstractAction
{
    /**
     * Handle ajax requests from ui-components
     *
     * @return void
     */
    public function execute()
    {
        if ($this->_request->getParam('namespace') === null) {
            $this->_redirect('noroute');
            return;
        }
        $component = $this->factory->create($this->_request->getParam('namespace'));
        $this->prepareComponent($component);
        $this->_response->appendBody((string)$component->render());
    }

    /**
     * Call prepare method in the component UI
     *
     * @param UiComponentInterface $component
     * @return void
     */
    protected function prepareComponent(UiComponentInterface $component)
    {
        foreach ($component->getChildComponents() as $child) {
            $this->prepareComponent($child);
        }
        $component->prepare();
    }
}
