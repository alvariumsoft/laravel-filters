<?php

namespace Alvarium\Filters\Filters\Defaults;


use Alvarium\Filters\Filters\FiltersCreator;

class DefaultFiltersCreator extends FiltersCreator
{
    public function getFilters(array $data): array
    {
        $filters = [];
        // 1 - get info
        foreach ($data as $key => $filter) {
            $propertyFilter = $this->filtersManager->getFilter($this->state->getProperties(), $key, $filter);
            if ($propertyFilter) {
                $filters[$key] = [
                    'title' => $propertyFilter->getTitle(),
                    'items' => $propertyFilter->getItems(),
                ];
            }
        }
        // 2 - create links
        // 4 - form result
        return $filters;
    }
    public function getChosenFilters(array $filters): array
    {
        $chosenFilters = [];
        foreach ($filters as $key => $filter) {
            $chosenItems = [];
            foreach ($filter['items'] as $item) {
                if ($item['chosen']) {
                    if ($key == 'prices') {
                        $item['value'] = $this->paramsManager->getParam($item['slug']);
                    }
                    $chosenItems[] = $item;
                }
            }
            if (!empty($chosenItems)) {
                $chosenFilters[$key] = [
                    'title' => $filter['title'],
                    'items' => $chosenItems,
                ];
            }
        }
        return $chosenFilters;
    }
}