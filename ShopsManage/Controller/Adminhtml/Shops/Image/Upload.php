<?php

namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops\Image;

use Magento\Framework\Controller\ResultFactory;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;

/**
 * Upload action
 *
 * Process uploading an image
 */
class Upload extends AbstractController
{
    /**
     * Image uploader
     *
     * @var \Sfedu\ShopsManage\Model\ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Sfedu\ShopsManage\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Sfedu\ShopsManage\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
