<?php

namespace Alvarium\Filters\Data;


abstract class RawData
{
    protected $state;
    public function __construct(State $state)
    {
        $this->state = $state;
    }
    public function cleanData(array $data): array
    {
        foreach ($data as $key => $filter) {
            if (empty($filter)) {
                unset($data[$key]);
            }
        }
        return $data;
    }
    abstract public function getDataFromProperties(): array;
    abstract public function fillDataFromProducts(array $data): array;
    abstract public function getDataPrices(array $data): array;
}