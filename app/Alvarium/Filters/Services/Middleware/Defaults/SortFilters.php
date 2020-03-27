<?php

namespace App\Alvarium\Filters\Services\Middleware\Defaults;


use Alvarium\Filters\Middlewares\Middleware;
use Alvarium\Filters\Data\State;

class SortFilters implements Middleware
{
    public function execute(array $filters): array
    {
        $properties = State::getInstance()->getProperties();
        foreach ($filters as $key => $filter) {
            $arrKey = explode('_', $key);
            $firstKeyPart = $arrKey[array_key_first($arrKey)];
            if ($firstKeyPart == 'property') {
                $propertyId = $arrKey[array_key_last($arrKey)];
                $property = $properties->find($propertyId);
                if ($property) {
                    $items = $filters[$key]['items'];
                    uasort($items, function ($a, $b) use ($property) {
                        $keyA = $property->propertyEnums->where('slug', $a['slug'])->keys()->first();
                        $keyB = $property->propertyEnums->where('slug', $b['slug'])->keys()->first();
                        if ($keyA == $keyB) {
                            return 0;
                        }
                        return ($keyA < $keyB) ? -1 : 1;
                    });
                    $filters[$key]['items'] = array_values($items);

                }
            }
        }
        return $filters;
    }
}