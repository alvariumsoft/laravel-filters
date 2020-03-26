<?php

namespace Alvarium\Filters\Queries;


interface QueryDecorator
{
    public function decorate(): Query;
}