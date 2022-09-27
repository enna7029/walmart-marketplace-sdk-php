<?php
namespace Walmart\Facades;

class RequestReport extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\RequestReport\Client';
    }
}