<?php
namespace Sfedu\ShopsManage\Controller\Adminhtml\Shops;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Controller\Adminhtml\AbstractController;
use Sfedu\ShopsManage\Model\ImageUploader;
use Sfedu\ShopsManage\Model\ShopFactory;

/**
 * Save action
 *
 * Process save shop action
 */
class Save extends AbstractController implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ShopFactory
     */
    protected $shopFactory;

    /**
     * @var ShopRepositoryInterface
     */
    private $shopRepository;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * Save constructor
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ShopFactory $shopFactory
     * @param ShopRepositoryInterface $shopRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ShopFactory $shopFactory,
        ShopRepositoryInterface $shopRepository,
        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->shopFactory = $shopFactory;
        $this->shopRepository = $shopRepository;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * Process save action
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data = $this->processTabsData($data);
            if (empty($data['shop_id'])) {
                $data['shop_id'] = null;
            }
            $data = $this->processImage($data);
            $data = $this->processProducts($data);

            /** @var \Sfedu\ShopsManage\Api\Data\ShopInterface $shop */
            $shop = $this->shopFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $shop = $this->shopRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $shop->setData($data);

            try {
                $this->shopRepository->save($shop);

                $this->messageManager->addSuccessMessage(__('You saved the shop.'));
                $this->dataPersistor->clear('shopsmanage_shop');
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the shop.'));
            }

            $this->dataPersistor->set('shopsmanage_shop', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process tabs info
     *
     * @param $data
     * @return array
     */
    private function processTabsData($data)
    {
        $result = !isset($data['general']) ? $data : array_merge($data['general'], $data['metadata']);
        $result = isset($data['assign_products']) ? array_merge($result, $data['assign_products']) : $result;
        return $result;
    }

    /**
     * Process products data
     *
     * @param $data
     * @return array
     */
    private function processProducts($data)
    {
        $posted_products = [];
        if (isset($data['loaded_product_ids'])) {
            $products = $data['loaded_product_ids'];
            if (is_array($products[0])) {
                foreach ($products as $product) {
                    $posted_products[] = $product['entity_id'];
                }
            } else {
                $posted_products = $products;
            }
        }
        $data['loaded_product_ids'] = $posted_products;
        return $data;
    }

    /**
     * Process image data
     *
     * @param $data
     * @return array
     */
    private function processImage($data)
    {
        if (isset($data['image'])) {
            $fileName = $data['image'][0]['name'];
            if (isset($data['image'][0]['tmp_name'])) {
                $this->imageUploader->moveFileFromTmp($fileName);
            } else {
                $url = $data['image'][0]['url'];
                if (substr($url, 0, 6) === "/media") {
                    //Remove /media part
                    $url = explode('/', $url);
                    unset($url[1]);
                    $url = implode('/', $url);

                    $this->imageUploader->copyExistingFile($fileName, $url);
                }
            }
            $data['image'] = $fileName;
        } else {
            $data['image'] = '';
        }
        return $data;
    }
}
