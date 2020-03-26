<?php


namespace Alvarium\Filters\Data;


use Illuminate\Database\Eloquent\Collection;

abstract class State
{
    private static $instance;
    protected $products;
    protected $properties;
    protected $propertyEnums;
    private function __construct()
    {
        $this->products = $this->fetchProducts();
        $this->properties = $this->fetchProperties();
        $this->propertyEnums = $this->fetchPropertyEnums();
    }
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPropertyEnums()
    {
        return $this->propertyEnums;
    }

    abstract protected function fetchProducts(): Collection;
    abstract protected function fetchProperties(): Collection;
    abstract protected function fetchPropertyEnums(): Collection;
}
