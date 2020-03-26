<?php


namespace Alvarium\Filters\Filters\Defaults;


use Alvarium\Filters\Filters\Filter;

class PriceFilter extends Filter
{
    protected $title = 'Price';
    public function getTitle()
    {
        return $this->title;
    }
    public function getItems()
    {
        $items = [];
        foreach ($this->data as $slug => $value) {
            $items[] = [
                'chosen' => $this->isChosen($slug),
                'value' => $value,
                'slug' => $slug,
            ];
        }
        return $items;
    }
    protected function isChosen($slug)
    {
        return $this->paramsManager->isSetKey($slug);
    }
}
