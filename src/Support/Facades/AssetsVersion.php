<?php

namespace TheCoderRaman\AssetsVersion\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AssetsVersion extends Facade
{
    /**
     * Get the registered name of the component or service
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'AssetsVersion';
    }
}
