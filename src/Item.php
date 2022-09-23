<?php

namespace Walmart;

class Item extends Facade
{
    protected static function getAccessor(): string
    {
       return 'Walmart\Items';
    }
}
