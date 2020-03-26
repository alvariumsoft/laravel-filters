<?php


namespace App\Alvarium\Filters\Services\Filters\Defaults;


use Alvarium\Filters\Filters\Filter;

class PropertyFilter extends Filter
{
    private $property;
    public function __construct($paramsManager, $resource, $key, $data)
    {
        parent::__construct($paramsManager, $resource, $key, $data);
        $this->property = $this->getProperty();
    }
    private function getProperty()
    {
        $id = substr($this->key, strrpos($this->key, '_') + 1);
        return $this->resource->find($id);
    }
    public function getTitle()
    {
        return $this->property->name ?? '';
    }
    public function getItems()
    {
        $items = [];
        if ($this->property && $this->property->propertyEnums->count()) {
            foreach ($this->data as $slug) {
                if ($propertyEnum = $this->property->propertyEnums->where('slug', $slug)->first()) {
                    $items[] = [
                        'chosen' => $this->isChosen($slug),
                        'value' => $propertyEnum->value,
                        'slug' => $slug,
                    ];
                }
            }
        }
        return $items;
    }
    protected function isChosen($slug)
    {
        if ($param = $this->paramsManager->getParam($this->key)) {
            if (is_array($param)) {
                return in_array($slug, $param);
            }
            return $param === $slug;
        }
        return false;
    }
}
