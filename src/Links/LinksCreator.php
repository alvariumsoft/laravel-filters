<?php

namespace Alvarium\Filters\Links;


use Alvarium\Filters\Params\ParamsManager;

abstract class LinksCreator
{
    protected $route;
    protected $chosenSlugs;
    protected $extraParams;
    protected $extraQueryParams;
    protected $paramsManager;

    public function __construct(ParamsManager $paramsManager, string $route, array $chosenFilters, array $extraQueryParams, array $extraParams = [])
    {
        $this->paramsManager = $paramsManager;
        $this->route = $route;
        $this->extraQueryParams = $extraQueryParams;
        $this->chosenSlugs = $this->setChosenSlugs($chosenFilters);
        $this->extraParams = $extraParams;
    }
    abstract protected function setChosenSlugs(array $chosenFilters): array;
    abstract public function makeChosenFiltersLinks(array $chosenFilters): array;
    abstract public function makeFiltersLinks(array $filters): array;
}