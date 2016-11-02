<?php

namespace Docean\Cofiguration;


interface ConfigurationInterface extends \ArrayAccess, \Iterator, \Countable
{

    public function set(string $name, $value) : Configuration;

    public function get(string $name) : Configuration;

    public function toArray() : array;

}