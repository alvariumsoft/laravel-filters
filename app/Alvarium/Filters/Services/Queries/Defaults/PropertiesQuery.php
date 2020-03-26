<?php


namespace Alvarium\Filters\Queries\Defaults;


use Alvarium\Filters\Queries\DecorateQuery;

class PropertiesQuery extends DecorateQuery
{
    public function addQuery($query, $chosenFilters)
    {
        foreach ($chosenFilters as $key => $filter) {
            if (strpos($key, 'property') === 0) {
                $slugs = array_column($filter['items'], 'slug');
                $query->where(function ($query) use ($slugs, $key) {
                    foreach ($slugs as $slug) {
                        $query->orWhereJsonContains("properties->{$key}", $slug);
                    }
                });
            }
        }

        return $query;
    }
}
