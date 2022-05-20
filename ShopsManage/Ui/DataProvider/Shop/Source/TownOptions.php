<?php

namespace Sfedu\ShopsManage\Ui\DataProvider\Shop\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Sfedu\ShopsManage\Api\ShopRepositoryInterface;

/**
 * Class TownOptions
 *
 * Supplies town options
 */
class TownOptions implements OptionSourceInterface
{
    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * TownOptions constructor
     *
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        ShopRepositoryInterface $shopRepository
    ) {
        $this->shopRepository = $shopRepository;
    }

    /**
     * Return array of options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $towns = $this->shopRepository->getTowns();

        $options = [];
        foreach ($towns as $town) {
            $options[] = [
                "value" => $town,
                "label" => $town
            ];
        }

        return $options;
    }
}
