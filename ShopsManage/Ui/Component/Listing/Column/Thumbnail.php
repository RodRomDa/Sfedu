<?php


namespace Sfedu\ShopsManage\Ui\Component\Listing\Column;


use Magento\Catalog\Helper\Image;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Sfedu\ShopsManage\Model\Shop\FileInfo;

/**
 * Class Thumbnail
 *
 * Renders thumbnail column in frontend
 */
class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'thumbnail';

    const ALT_FIELD = 'name';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var FileInfo
     */
    protected $fileInfo;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * Thumbnail constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param FileInfo $fileInfo
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        FileInfo $fileInfo,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->fileInfo = $fileInfo;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $shop = new \Magento\Framework\DataObject($item);
                $imageURL = empty($item['image']) ? $this->imageHelper->getDefaultPlaceholderUrl('thumbnail')
                                                    : $this->fileInfo->getAbsolutePath($item['image']);
                $item[$fieldName . '_src'] = $imageURL;
                $item[$fieldName . '_alt'] = $item['image'];
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'shops/shop',
                    ['id' => $shop['shop_id']]
                );
                $item[$fieldName . '_orig_src'] = $imageURL;
            }
        }

        return $dataSource;
    }

    /**
     * Get Alt
     *
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return $row[$altField] ?? null;
    }
}
