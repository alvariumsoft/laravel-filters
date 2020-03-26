<?php


namespace App\Alvarium\Filters\Services\Params\Defaults;


use Alvarium\Filters\Data\State;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Alvarium\Filters\Params\ParamsStrategy;

class DefaultParamsStrategy implements ParamsStrategy
{
    protected $segmentParams = [
        'property_2'
    ];
    public function getParams(array $params): array
    {
        $resultParams = [];

        foreach ($params as $param) {
            $arrParam = explode('-', $param);
            $newPropertyEnums = State::getInstance()->getPropertyEnums()->whereIn('slug', $arrParam);
            if ($newPropertyEnums->count() != count($arrParam)) {
                throw new NotFoundHttpException();
            }
            foreach ($newPropertyEnums as $propertyEnum) {
                if (isset($resultParams["property_{$propertyEnum->property->id}"])) {
                    if (is_array($resultParams["property_{$propertyEnum->property->id}"])) {
                        $resultParams["property_{$propertyEnum->property->id}"][] = $propertyEnum->slug;
                    } else {
                        $resultParams["property_{$propertyEnum->property->id}"] = [
                            $resultParams["property_{$propertyEnum->property->id}"],
                            $propertyEnum->slug
                        ];
                    }
                } else {
                    $resultParams["property_{$propertyEnum->property->id}"] = $propertyEnum->slug;
                }
            }
        }

        return $resultParams;
    }
    public function getQueryExtraParams(array $query): array
    {
        $resultParams = [];

        foreach ($query as $key => $param) {
            if ($key !== 'min_price' && $key !== 'max_price' && strpos($key, 'property') !== 0) {
                $resultParams[$key] = $param;
            }
        }

        return $resultParams;
    }

    /**
     * @return array
     */
    public function getSegmentParams(): array
    {
        return $this->segmentParams;
    }

}
