<?php


namespace Alvarium\Filters\Queries;


class Builder
{
    private $query;
    private $chosenFilters;
    public function __construct(array $chosenFilters, $query)
    {
        $this->query = $query;
        $this->chosenFilters = $chosenFilters;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getChosenFilters()
    {
        return $this->chosenFilters;
    }

}
