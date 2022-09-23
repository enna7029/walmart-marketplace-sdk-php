<?php
namespace Walmart\Facades;

class MultipleReports extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Reports\Client';
    }
}
