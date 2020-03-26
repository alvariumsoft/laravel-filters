<?php

namespace Alvarium\Filters;


class Filters
{
    private $config;
    public function __construct()
    {
        $this->config = config('filters');
    }
    public function getManager(array $params, array $query, string $route, array $extraParams = []): Manager
    {
        return new Manager($this->config, $params, $query, $route, $extraParams);
    }
}