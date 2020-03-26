<?php

namespace Alvarium\Filters;


use Illuminate\Support\Facades\Cache;

class CacheManager
{
    private $key;
    private $time;
    public function __construct(array $params, int $time)
    {
        $this->key = $this->createKey($params);
        $this->time = $time;
    }
    private function createKey(array $params)
    {
        $key = app()->getLocale() . '_raw_filters_' . implode('_', $params);
        return md5($key);
    }
    public function has(): string
    {
        return Cache::has($this->key);
    }
    public function put(array $data): void
    {
        Cache::put($this->key, $data, $this->time);
    }
    public function get(): array
    {
        $data = Cache::get($this->key);
        if (is_array($data)) {
            return $data;
        }
        return [];
    }
}