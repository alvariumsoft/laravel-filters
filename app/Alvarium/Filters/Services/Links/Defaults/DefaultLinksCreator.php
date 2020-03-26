<?php

namespace App\Alvarium\Filters\Services\Links\Defaults;


use Alvarium\Filters\Links\LinksCreator;

class DefaultLinksCreator extends LinksCreator
{
    protected function setChosenSlugs(array $chosenFilters): array
    {
        $chosenSlugs = [];

        foreach ($chosenFilters as $key => $filter) {
            $slugs = [];
            foreach ($filter['items'] as $item) {
                if (!empty($item['chosen'])) {
                    $slugs[] = $item['slug'];
                }
            }
            $chosenSlugs[$key] = $slugs;
        }

        return $chosenSlugs;
    }
    public function makeChosenFiltersLinks(array $chosenFilters): array
    {
        $newChosenFilters = [];

        // todo: refactor this function
        foreach ($chosenFilters as $key => $chosenFilter) {
            $newChosenFilters[$key] = $chosenFilter;
            foreach ($chosenFilter['items'] as $keyItem => $item) {
                $newSlugs = $this->chosenSlugs[$key];
                if (!empty($item['chosen'])) {
                    unset($newSlugs[array_search($item['slug'], $newSlugs)]);
                } else {
                    $newSlugs[] = $item['slug'];
                }

                $copyChosenSlugs = $this->chosenSlugs;
                $copyChosenSlugs[$key] = $newSlugs;
                $newChosenSlugs = [];
                $counter = 1;
                foreach ($copyChosenSlugs as $keySlug => $values) {
                    if (!empty($values)) {
                        if ($this->paramsManager->isSegmentParam($keySlug)) {
                            $newChosenSlugs['param' . $counter++] = implode('-', $values);
                        } elseif ($keySlug == 'prices') {
                            if (in_array('min_price', $values)) {
                                $newChosenSlugs['min_price'] = $this->paramsManager->getParam('min_price');
                            }
                            if (in_array('max_price', $values)) {
                                $newChosenSlugs['max_price'] = $this->paramsManager->getParam('max_price');
                            }
                        } else {
                            $newChosenSlugs[$keySlug] = $values;
                        }
                    }
                }

                $params = array_merge($this->extraParams, $newChosenSlugs, $this->extraQueryParams);
                $newChosenFilters[$key]['items'][$keyItem]['link'] = route($this->route, $params);
            }
        }

        return $newChosenFilters;
    }
    public function makeFiltersLinks(array $filters): array
    {
        $newFilters = [];

        // todo: refactor this function
        foreach ($filters as $key => $chosenFilter) {
            $newFilters[$key] = $chosenFilter;
            foreach ($chosenFilter['items'] as $keyItem => $item) {
                $copyChosenSlugs = $this->chosenSlugs;

                if (isset($this->chosenSlugs[$key])) {
                    $newSlugs = $this->chosenSlugs[$key];
                    if (!empty($item['chosen'])) {
                        unset($newSlugs[array_search($item['slug'], $newSlugs)]);
                    } else {
                        $newSlugs[] = $item['slug'];
                    }

                    $copyChosenSlugs[$key] = $newSlugs;
                } else {
                    $copyChosenSlugs[$key][] = $item['slug'];
                }
                $newChosenSlugs = [];
                $counter = 1;
                foreach ($copyChosenSlugs as $keySlug => $values) {
                    if (!empty($values)) {
                        if ($this->paramsManager->isSegmentParam($keySlug)) {
                            $newChosenSlugs['param' . $counter++] = implode('-', $values);
                        } elseif ($keySlug == 'prices') {
                            if (in_array('min_price', $values)) {
                                $newChosenSlugs['min_price'] = $this->paramsManager->getParam('min_price');
                            }
                            if (in_array('max_price', $values)) {
                                $newChosenSlugs['max_price'] = $this->paramsManager->getParam('max_price');
                            }
                        } else {
                            $newChosenSlugs[$keySlug] = $values;
                        }
                    }
                }

                $params = array_merge($this->extraParams, $newChosenSlugs, $this->extraQueryParams);
                $newFilters[$key]['items'][$keyItem]['link'] = route($this->route, $params);
            }
        }

        return $newFilters;
    }
}