<?php

namespace Walmart\Facades;

class Price extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Price\Price';
    }
}
