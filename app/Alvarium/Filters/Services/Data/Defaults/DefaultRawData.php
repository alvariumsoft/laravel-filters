<?php

namespace App\Alvarium\Filters\Services\Data\Defaults;


use App\Product;
use Alvarium\Filters\Data\RawData;

class DefaultRawData extends RawData
{
    private $propertiesToFill = [];
    public function getDataFromProperties(): array
    {
        $properties = $this->state->getProperties()->keyBy('id');

        $propertiesToFill = [];

        foreach ($properties as $property) {
            $propertiesToFill[$property->id] = "property_{$property->id}";
        }

        $data = array_fill_keys(array_values($propertiesToFill), []);

        $this->propertiesToFill = $propertiesToFill;

        return $data;
    }
    public function fillDataFromProducts(array $data): array
    {
        $count = 0;
        $products = $this->state->getProducts();
        $propertiesToFill = $this->propertiesToFill;
        $properties = $this->state->getProperties()->keyBy('id');

        foreach ($products as $product) {
            if (!empty($product->properties)) {
                foreach ($propertiesToFill as $propertyKey) {
                    if (isset($product->properties[$propertyKey]) && !isset($data[$propertyKey][$product->properties[$propertyKey]])) {
                        $data[$propertyKey][$product->properties[$propertyKey]] = $product->properties[$propertyKey];
                    }
                    $propertyId = substr($propertyKey, -1);
                    if (($property = $properties->find($propertyId)) && count($data[$propertyKey]) == $property->propertyEnums->count()) {
                        unset($propertiesToFill[$propertyId]);
                    }
                }
            }
            if (empty($propertiesToFill)) {
                break;
            }
            $count++;
        }

        return $data;
    }
    public function getDataPrices(array $data): array
    {
        $maxPrice = Product::max('price');
        $minPrice = Product::min('price');

        $data['prices'] = [
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ];

        return $data;
    }
}