<?php


namespace Alvarium\Filters\Filters;


use Alvarium\Filters\Params\ParamsManager;
use Illuminate\Database\Eloquent\Collection;

class FiltersManager
{
    private $paramsManager;
    private $receiveFilter;
    public function __construct(ParamsManager $paramsManager, ReceiveFilter $receiveFilter)
    {
        $this->paramsManager = $paramsManager;
        $this->receiveFilter = $receiveFilter;
    }
    public function getFilter(Collection $resource, string $key, array $data)
    {
        return $this->receiveFilter->getFilter($this->paramsManager, $resource, $key, $data);
    }
}
