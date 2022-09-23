<?php

namespace Walmart\Helpers;

class Stack
{
    protected $top;

    protected $container = [];


    public function __construct()
    {
        $this->top = -1;
        $this->container = [];
    }

    public function count() {
        return $this->top;
    }

    public function top(): mixed
    {
        return $this->container[$this->top];
    }

    public function push($value): void
    {
        $this->container[++$this->top] = $value;
    }

    public function pop(): bool
    {
        if (!$this->isEmpty())
            return false;
        $this->container[] = null;
        --$this->top;
        return true;
    }

    public function isEmpty(): bool
    {
        return ($this->top == 0) ? true : false;
    }

}
