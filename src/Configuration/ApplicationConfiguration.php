<?php

namespace Docean\Cofiguration;


class ApplicationConfiguration implements ConfigurationInterface
{
    private $configuration = null;
    private $key = null;
    private $keys = null;

    public function set(string $name, $value) : Configuration
    {
        $this->offsetSet($name, $value);
        return $this;
    }

    public function get(string $name) : Configuration
    {
        return $this->offsetGet($name);;
    }

    public function toArray() : array
    {
        $configuration = [];

        if (empty($this->configuration)) {
            return $configuration;
        }

        foreach ($this->configuration as $name => $value) {

            if ($value instanceof Configuration) {
                $configuration[$name] = $value->toArray();
            } elseif ($value instanceof \stdClass) {
                $configuration[$name] = (array)$value;
            } else {
                $configuration[$name] = $value;
            }
        }

        return $configuration;
    }

    public function current() : Configuration
    {
        $this->configuration[$this->key];
        return $this;
    }

    public function next() : Configuration
    {
        $this->key = array_shift($this->keys);
    }

    public function key() : int
    {
        return $this->key;
    }

    public function valid() : bool
    {
        return $this->offsetExists($this->key);
    }

    public function rewind() : Configuration
    {
        $this->keys = array_keys($this->configuration);
        $this->key = array_shift($this->keys);
        return $this;
    }

    public function offsetExists($offset) : bool
    {
        return (bool)isset($this->configuration[$offset]);
    }

    public function offsetGet($offset) : Configuration
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfBoundsException("Configuration {$offset} does not exists");
        }

        $config = $this->configuration[$offset];
        $configuration = (new ApplicationConfiguration())->set($offset, $config);
        return $configuration;
    }

    public function offsetSet($offset, $value) :  Configuration
    {
        if (
            is_object($value) &&
            !$value instanceof Configuration &&
            !$value instanceof \stdClass
        ) {
            $message = "Invalid type of object, Configurations should be ";
            $message .= "object of type \\stdClass or Docean\\Configuration\\ConfigurationInterface ";
            $message .= "Object of type %s passed as argument ";
            throw new \InvalidArgumentException(sprintf($message), get_class($value));
        }

        $this->configuration[$offset] = $value;
        return $this;
    }

    public function offsetUnset($offset) : Configuration
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfBoundsException("Configuration {$offset} does not exists");
        }

        unset($this->configuration[$offset]);
        return $this;
    }

    public function count() : int
    {
        return $this->count($this->configuration);
    }


}