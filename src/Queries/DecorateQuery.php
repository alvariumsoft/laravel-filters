<?php


namespace Alvarium\Filters\Queries;


abstract class DecorateQuery implements Query
{
    protected $query;
    public function __construct(Query $query)
    {
        $this->query = $query;
    }
    public function process(Builder $builder)
    {
        $query = $builder->getQuery();
        $query = $this->addQuery($query, $builder->getChosenFilters());
        $builder->setQuery($query);
        return $this->query->process($builder);
    }
    abstract protected function addQuery($query, array $chosenFilters);
}
