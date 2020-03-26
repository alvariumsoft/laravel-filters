<?php


namespace Alvarium\Filters\Filters;


use Alvarium\Filters\Params\ParamsManager;
use Illuminate\Database\Eloquent\Collection;

interface ReceiveFilter
{
    public function getFilter(ParamsManager $paramsManager, Collection $resource, string $key, array $data): Filter;
}
