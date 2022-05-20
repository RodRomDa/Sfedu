<?php

namespace Sfedu\ShopsManage\Ui\Component\Listing\Filter;

use Magento\Ui\Component\Filters\Type\Range;

class TimeRange extends Range
{
    /**
     * Apply filter by its type
     *
     * @param string $type
     * @param string $value
     * @return void
     */
    protected function applyFilterByType($type, $value)
    {
        if ($this->isTime($value)) {
            $filter = $this->filterBuilder->setConditionType($type)
                ->setField($this->getName())
                ->setValue($value)
                ->create();
            $this->getContext()->getDataProvider()->addFilter($filter);
        }
    }

    private function isTime(&$time)
    {
        $time = trim($time);
        $regex = "/^([01]\d|2[0-3])(:[0-5]\d){0,2}$/";
        return preg_match($regex, $time);
    }
}
