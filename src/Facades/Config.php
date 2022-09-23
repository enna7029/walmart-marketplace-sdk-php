<?php

namespace Walmart\Facades;


class Config extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Configs\Config';
    }
}
