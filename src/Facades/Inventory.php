<?php

namespace Walmart\Facades;

class Inventory extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Inventory\Inventory';
    }
}
