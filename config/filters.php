<?php

return [
    'services' => [
        'state' => \App\Services\Filters\Data\Custom\DefaultState::class,
        'params_strategy' => \App\Services\Filters\Params\Custom\DefaultParamsStrategy::class,
        'receive_filter' => \App\Services\Filters\Filters\Custom\DefaultReceiveFilter::class,
        'raw_data' => \App\Services\Filters\Data\Custom\DefaultRawData::class,
        'filters_creator' => \App\Services\Filters\Filters\Custom\DefaultFiltersCreator::class,
        'query_decorator' => \App\Services\Filters\Queries\Custom\DefaultQueryDecorator::class,
        'links_creator' => \App\Services\Filters\Links\Custom\DefaultLinksCreator::class,
    ],
    'middleware' => [
        \App\Services\Filters\Middlewares\Custom\SortFilters::class,
    ],
    'settings' => [
        'cache_time' => 3600 * 24,
    ],
];