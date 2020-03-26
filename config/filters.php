<?php

return [
    'services' => [
        'state' => \App\Alvarium\Filters\Services\Data\Defaults\DefaultState::class,
        'params_strategy' => \App\Alvarium\Filters\Services\Params\Defaults\DefaultParamsStrategy::class,
        'receive_filter' => \App\Alvarium\Filters\Services\Filters\Defaults\DefaultReceiveFilter::class,
        'raw_data' => \App\Alvarium\Filters\Services\Data\Defaults\DefaultRawData::class,
        'filters_creator' => \App\Alvarium\Filters\Services\Filters\Defaults\DefaultFiltersCreator::class,
        'query_decorator' => \App\Alvarium\Filters\Services\Queries\Defaults\DefaultQueryDecorator::class,
        'links_creator' => \App\Alvarium\Filters\Services\Links\Defaults\DefaultLinksCreator::class,
    ],
    'middleware' => [
        \App\Alvarium\Filters\Services\Middlewares\Defaults\SortFilters::class,
    ],
    'settings' => [
        'cache_time' => 3600 * 24,
    ],
];