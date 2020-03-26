<?php


namespace Alvarium\Filters\Filters;


use Alvarium\Filters\Params\ParamsManager;
use Illuminate\Database\Eloquent\Collection;

abstract class Filter
{
    protected $resource;
    protected $key;
    protected $data;
    protected $paramsManager;
    public function __construct(ParamsManager $paramsManager, Collection $resource, string $key, array $data)
    {
        $this->resource = $resource;
        $this->key = $key;
        $this->data = $data;
        $this->paramsManager = $paramsManager;
    }
    abstract public function getItems();
    abstract public function getTitle();
    abstract protected function isChosen($slug);
}
