<?php
namespace Sfedu\ShopsManage\Model\Shop;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Sfedu\ShopsManage\Api\Data\ShopInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Model\ResourceModel\Shop\CollectionFactory;
use Sfedu\ShopsManage\Model\ShopFactory;

/**
 * Class DataProvider
 *
 * Provides data for shop form
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * @var ShopFactory
     */
    protected $shopFactory;

    /**
     * @var \Sfedu\ShopsManage\Model\Shop\FileInfo
     */
    protected $fileInfo;

    /**
     * DataProvider constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $shopeCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param RequestInterface $request
     * @param ShopRepositoryInterface $shopRepository
     * @param ShopFactory $shopFactory
     * @param FileInfo $fileInfo
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $shopeCollectionFactory,
        DataPersistorInterface $dataPersistor,
        RequestInterface $request,
        ShopRepositoryInterface $shopRepository,
        ShopFactory $shopFactory,
        FileInfo $fileInfo,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $shopeCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
        $this->shopRepository = $shopRepository;
        $this->shopFactory = $shopFactory;
        $this->fileInfo = $fileInfo;
    }

    /**
     * Main action of data provider
     * returns data to display
     *
     * @return array
     */
    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }

        $shop = $this->getCurrentShop();
        $result = $shop->getData();
        $result['image'] = $this->processImage($shop);
        $result['store_ids'] = $shop->getStores();

        $shopId = $shop->getId();
        $this->loadedData[$shopId]['general'] = $result;
        $this->loadedData[$shopId]['metadata'] = $shop->getMeta();
        $this->loadedData[$shopId]['assign_products'] = [
            'loaded_product_ids' => $shop->getProductIds()
        ];

        return $this->loadedData;
    }

    /**
     * Retrieve current shop
     *
     * @return ShopInterface
     */
    private function getCurrentShop()
    {
        $shopId = $this->request->getParam('id');
        if ($shopId) {
            try {
                $shop = $item = $this->shopRepository->getById($shopId);
            } catch (LocalizedException $exception) {
                $shop = $this->shopFactory->create();
            }

            return $shop;
        }

        $data = $this->dataPersistor->get('shopsmanage_shop');

        if (empty($data)) {
            return $this->shopFactory->create();
        }
        $this->dataPersistor->clear('shopsmanage_shop');

        return $this->shopFactory->create()
            ->setData($data);
    }

    /**
     * Process image information
     *
     * @param \Sfedu\ShopsManage\Api\Data\ShopInterface $shop
     * @return array[]|null
     */
    private function processImage($shop)
    {
        $fileName = $shop->getImage();

        if ($this->fileInfo->isExist($fileName)) {
            $stat = $this->fileInfo->getStat($fileName);
            $image = [
                0 => [
                    'name' =>  basename($fileName),
                    'url' => $this->fileInfo->getAbsolutePath($fileName),
                    'size' => isset($stat) ? $stat['size'] : 0,
                    'type' => $this->fileInfo->getMimeType($fileName)
                ]
            ];

            return $image;
        } else {
            return null;
        }
    }
}
