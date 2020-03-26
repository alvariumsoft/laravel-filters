<?php


namespace Alvarium\Filters\Queries;


interface Query
{
    public function process(Builder $builder);
}
