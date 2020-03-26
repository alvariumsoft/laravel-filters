<?php


namespace Alvarium\Filters\Filters\Defaults;


use Alvarium\Filters\Filters\Filter;
use Alvarium\Filters\Filters\ReceiveFilter;
use Alvarium\Filters\Params\ParamsManager;
use Illuminate\Database\Eloquent\Collection;

class DefaultReceiveFilter implements ReceiveFilter
{
    public function getFilter(ParamsManager $paramsManager, Collection $resource, string $key, array $data): Filter
    {
        if (strpos($key, 'property') === 0) {
            return new PropertyFilter($paramsManager, $resource, $key, $data);
        } elseif (strpos($key, 'prices') === 0) {
            return new PriceFilter($paramsManager, $resource, $key, $data);
        }
        return null;
    }
}
