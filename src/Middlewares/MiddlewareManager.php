<?php

namespace Alvarium\Filters\Middlewares;


class MiddlewareManager
{
    private $middlewares = [];
    public function __construct(array $middlewares)
    {
        foreach ($middlewares as $middleware) {
            $this->addMiddleware(new $middleware());
        }
    }

    public function addMiddleware(Middleware $middleware): void
    {
        if (!in_array($middleware, $this->middlewares)) {
            $this->middlewares[] = $middleware;
        }
    }
    public function execute(array $filters): array
    {
        foreach ($this->middlewares as $middleware) {
            $filters = $middleware->execute($filters);
        }
        return $filters;
    }
}