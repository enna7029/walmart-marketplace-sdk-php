<?php
namespace Walmart;

abstract class Facade
{
    /**
     * @var array
     */
    protected static array $instances = [];

    /**
     * @return string
     */
    protected static function getAccessor(): string
    {
        throw new RuntimeException("请设置facade类");
    }

    public static function getInstance()
    {
        $name = static::getAccessor();
        if (!isset(static::$instances[$name])) {
            static::$instances[$name] = new $name();
        }
        return static::$instances[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = static::getInstance();
        return $instance->$method(...$arguments);
    }
}
