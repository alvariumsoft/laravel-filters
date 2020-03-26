<?php

namespace Alvarium\Filters\Data\Defaults;


use Alvarium\Filters\Data\State;
use App\Product;
use App\Property;
use Illuminate\Database\Eloquent\Collection;

class DefaultState extends State
{
    protected function fetchProducts(): Collection
    {
        return Product::select([
            'products.id',
            'products.properties',
        ])->get();
    }
    protected function fetchProperties(): Collection
    {
        return Property::with('propertyEnums')->orderBy('sort')->get();
    }
    protected function fetchPropertyEnums(): Collection
    {
        $arrPropertyEnums = [];
        foreach ($this->properties as $property) {
            foreach ($property->propertyEnums as $propertyEnum) {
                $propertyEnum->property = $property;
                $arrPropertyEnums[$propertyEnum->id] = $propertyEnum;
            }
        }

        return new Collection($arrPropertyEnums);
    }

}