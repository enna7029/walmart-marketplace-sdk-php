<?php

namespace Walmart\Facades;


class Items extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Items\Client';
    }
}
