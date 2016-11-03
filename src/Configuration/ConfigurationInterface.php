<?php

namespace Docean\Cofiguration;


interface ConfigurationInterface extends \ArrayAccess, \Iterator, \Countable
{

    public function set(string $name, $value) : ConfigurationInterface;

    public function get(string $name) : ConfigurationInterface;

    public function toArray() : array;

}