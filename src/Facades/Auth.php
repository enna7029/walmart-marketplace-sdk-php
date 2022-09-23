<?php
namespace Walmart\Facades;

class Auth extends Facade
{
    protected static function getAccessor(): string
    {
        return 'Walmart\Authentication\Auth';
    }
}
