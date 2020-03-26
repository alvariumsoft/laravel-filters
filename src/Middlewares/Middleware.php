<?php

namespace Alvarium\Filters\Middlewares;


interface Middleware
{
    public function execute(array $filters): array;
}