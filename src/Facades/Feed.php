<?php

namespace Walmart\Facades;

class Feed extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Feeds\Feeds';
    }
}
