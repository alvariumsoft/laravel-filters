<?php


namespace Alvarium\Filters\Queries\Defaults;


use Alvarium\Filters\Queries\Query;
use Alvarium\Filters\Queries\Builder;

class MainQuery implements Query
{
    public function process(Builder $builder)
    {
        return $builder->getQuery();
    }
}
