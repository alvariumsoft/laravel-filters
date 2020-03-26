<?php

namespace Alvarium\Filters\Filters;


use Alvarium\Filters\Params\ParamsManager;
use Alvarium\Filters\Data\State;

abstract class FiltersCreator
{
    protected $filtersManager;
    protected $state;
    protected $paramsManager;
    public function __construct(FiltersManager $filtersManager, State $state, ParamsManager $paramsManager)
    {
        $this->filtersManager = $filtersManager;
        $this->state = $state;
        $this->paramsManager = $paramsManager;
    }
    abstract public function getFilters(array $data): array;
    abstract public function getChosenFilters(array $filters): array;
}