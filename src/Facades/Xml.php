<?php

namespace Walmart\Facades;


class Xml extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Helpers\Xml';
    }
}
