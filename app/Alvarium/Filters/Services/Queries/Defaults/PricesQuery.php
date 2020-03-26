<?php


namespace Alvarium\Filters\Queries\Defaults;


use Alvarium\Filters\Queries\DecorateQuery;

class PricesQuery extends DecorateQuery
{
    public function addQuery($query, array $chosenFilters)
    {
        if (isset($chosenFilters['prices'])) {
            $minPrice = 0;
            $maxPrice = 0;
            foreach ($chosenFilters['prices']['items'] as $item) {
                if ($item['slug'] === 'min_price') {
                    $minPrice = $item['value'];
                }
                if ($item['slug'] === 'max_price') {
                    $maxPrice = $item['value'];
                }
            }
            if ($minPrice && $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            } elseif ($minPrice) {
                $query->where('price', '>=', $minPrice);
            } elseif ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            }
        }

        return $query;
    }
}
