<?php


namespace Alvarium\Filters\Params;


class ParamsManager
{
    private $params;
    private $query;
    private $paramsStrategy;
    public function __construct(array $params, array $query, ParamsStrategy $paramsStrategy)
    {
        $this->paramsStrategy = $paramsStrategy;
        $this->params = $this->paramsStrategy->getParams($params);
        $this->query = $query;
    }
    public function getParam(string $key)
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }
        if (isset($this->query[$key])) {
            return $this->query[$key];
        }
        return null;
    }
    public function isSetKey(string $key)
    {
        return isset($this->params[$key]) || isset($this->query[$key]);
    }
    public function getExtraQueryParams(): array
    {
        return $this->paramsStrategy->getQueryExtraParams($this->query);
    }
    public function isSegmentParam(string $key): bool
    {
        return in_array($key, $this->paramsStrategy->getSegmentParams());
    }
}
