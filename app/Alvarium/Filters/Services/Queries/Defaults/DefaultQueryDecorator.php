<?php

namespace App\Alvarium\Filters\Services\Queries\Defaults;


use Alvarium\Filters\Queries\QueryDecorator;
use Alvarium\Filters\Queries\Query;

class DefaultQueryDecorator implements QueryDecorator
{
    public function decorate(): Query
    {
        return new PricesQuery(new PropertiesQuery(new MainQuery()));
    }
}