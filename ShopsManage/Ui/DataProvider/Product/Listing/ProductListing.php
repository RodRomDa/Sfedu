<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Product\Listing;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;
use Sfedu\ShopsManage\Model\Shop;

/**
 * Class ProductListing
 *
 * Data provider for product lisiting
 */
class ProductListing extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    /**
     * @var DataPersistorInterface $dataPersistor
     */
    protected $dataPersistor;

    /**
     * @var ShopRepositoryInterface $shopRepository
     */
    protected $shopRepository;

    /**
     * @var FilterBuilder $filterBuilder
     */
    protected $filterBuilder;

    /**
     * @var RequestInterface $request
     */
    protected $request;

    /**
     * ProductListing constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $modifiersPool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        ShopRepositoryInterface $shopRepository,
        FilterBuilder $filterBuilder,
        RequestInterface $request,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = [],
        PoolInterface $modifiersPool = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->shopRepository = $shopRepository;
        $this->filterBuilder = $filterBuilder;
        $this->request = $request;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $collectionFactory,
            $addFieldStrategies,
            $addFilterStrategies,
            $meta,
            $data,
            $modifiersPool
        );
    }

    /**
     * Return data for product listing
     *
     * @return array
     */
    public function getData()
    {
        //To mark selected rows
        $param = $this->request->getPostValue('paging');
        if (isset($param)&&isset($param['notLimits'])) {
            $this->setSelectedFilter();
        }

        //Set Stores Filter
        $this->setStoreFilter();

        return parent::getData();
    }

    /**
     * Set selected items
     */
    protected function setSelectedFilter()
    {
        $shopId = $this->dataPersistor->get('shopsmanage_shop_edit_id');
        /** @var Shop $shop */
        $shop = $this->shopRepository->getById($shopId);
        $productIds = $shop->getProductIds();
        $filter = $this->filterBuilder
            ->setField('entity_id')
            ->setConditionType('in')
            ->setValue($productIds)
            ->create();
        $this->addFilter($filter);
    }

    /**
     * Filter products accroding to store view domain
     */
    protected function setStoreFilter()
    {
        $shopId = $this->dataPersistor->get('shopsmanage_shop_edit_id');
        /** @var Shop $shop */
        $shop = $this->shopRepository->getById($shopId);
        $websiteIds = $shop->getWebsites();
        if (isset($websiteIds)) {
            $this->collection->addWebsiteFilter($websiteIds);
        }
    }
}
