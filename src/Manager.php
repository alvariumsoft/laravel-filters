<?php


namespace Alvarium\Filters;


use Alvarium\Filters\Data\RawData;
use Alvarium\Filters\Filters\FiltersManager;
use Alvarium\Filters\Middlewares\MiddlewareManager;
use Alvarium\Filters\Params\ParamsManager;
use Alvarium\Filters\Queries\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Manager
{
    private $config;

    private $state;
    private $data;
    private $paramsManager;
    private $filterManager;
    private $filtersCreator;
    private $queryDecorator;
    private $linksCreator;

    private $middlewareManager;

    private $filters;
    private $chosenFilters;

    public function __construct(array $config, array $params, array $query, string $route, array $extraParams = [])
    {
        $this->config = $config;
        $this->locateServices($params, $query);
        $this->run($route, $extraParams);
    }

    private function locateServices(array $params, array $query): void
    {
        $state = $this->config['services']['state'];
        $this->state = $state::getInstance();

        $paramsStrategy = $this->config['services']['params_strategy'];
        $this->paramsManager = new ParamsManager($params, $query, new $paramsStrategy());

        $receiveFilter = $this->config['services']['receive_filter'];
        $this->filterManager = new FiltersManager($this->paramsManager, new $receiveFilter());

        $filtersCreator = $this->config['services']['filters_creator'];
        $this->filtersCreator = new $filtersCreator($this->filterManager, $this->state, $this->paramsManager);

        $queryDecorator = $this->config['services']['query_decorator'];
        $this->queryDecorator = new $queryDecorator();

        $this->middlewareManager = new MiddlewareManager($this->config['middleware']);
    }

    private function run(string $route, array $extraParams = []): void
    {
        $rawData = $this->config['services']['raw_data'];
        $cacheManager = new CacheManager($extraParams, $this->config['settings']['cache_time']);
        if ($cacheManager->has()) {
            $this->data = $cacheManager->get();
        } else {
            $this->data = $this->getData(new $rawData($this->state));
            $cacheManager->put($this->data);
        }

        $this->filters = $this->makeFilters();
        $this->chosenFilters = $this->makeChosenFilters($this->filters);

        $linksCreator = $this->config['services']['links_creator'];
        $extraQueryParams = $this->paramsManager->getExtraQueryParams();
        $this->linksCreator = new $linksCreator($this->paramsManager, $route, $this->chosenFilters, $extraQueryParams, $extraParams);
        $this->chosenFilters = $this->linksCreator->makeChosenFiltersLinks($this->chosenFilters);
        $this->filters = $this->linksCreator->makeFiltersLinks($this->filters);
    }

    private function getData(RawData $rawData): array
    {
        $data = $rawData->getDataFromProperties();
        $data = $rawData->fillDataFromProducts($data);
        $data = $rawData->getDataPrices($data);
        $data = $rawData->cleanData($data);

        return $data;
    }

    private function makeFilters(): array
    {
        $filters = $this->filtersCreator->getFilters($this->data);
        $filters = $this->middlewareManager->execute($filters);
        return $filters;
    }

    private function makeChosenFilters(array $filters): array
    {
        return $this->filtersCreator->getChosenFilters($filters);
    }

    public function getProductIds(EloquentBuilder $eloquentQuery): array
    {
        $builder = new Builder($this->chosenFilters, $eloquentQuery);
        $query = $this->queryDecorator->decorate();
        $ids = $query->process($builder)->get()->pluck('id')->toArray();
        return $ids;
    }

    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return mixed
     */
    public function getChosenFilters()
    {
        return $this->chosenFilters;
    }

}
