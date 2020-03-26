<?php


namespace Alvarium\Filters\Params;


interface ParamsStrategy
{
    public function getParams(array $params): array;
    public function getQueryExtraParams(array $query): array;
    public function getSegmentParams(): array;
}
