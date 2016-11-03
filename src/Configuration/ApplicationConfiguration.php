<?php
namespace Docean\Cofiguration;


class ApplicationConfiguration implements ConfigurationInterface
{
    private $configuration = null;
    private $key = 0;
    private $keys = null;

    public function __construct()
    {
        $this->rewind();
    }

    public function set(string $name, $value) : ConfigurationInterface
    {
        $this->offsetSet($name, $value);
        return $this;
    }

    public function get(string $name) : ConfigurationInterface
    {
        return $this->offsetGet($name);
    }

    public function toArray() : array
    {
        $configuration = [];

        if (empty($this->configuration)) {
            return $configuration;
        }

        foreach ($this->configuration as $name => $value) {

            if ($value instanceof ConfigurationInterface) {
                $configuration[$name] = $value->toArray();
            } elseif ($value instanceof \stdClass) {
                $configuration[$name] = (array)$value;
            } else {
                $configuration[$name] = $value;
            }
        }

        return $configuration;
    }

    public function current() : ConfigurationInterface
    {
        $this->configuration[$this->keys[$this->key]];
        return $this;
    }

    public function next() : ConfigurationInterface
    {
        $this->key++;
        return $this;
    }

    public function key()
    {
        return $this->keys[$this->key];
    }

    public function valid() : bool
    {
        $offset = $this->keys[$this->key];
        return $this->offsetExists($offset);
    }

    public function rewind() : ConfigurationInterface
    {
        $this->key = 0;
        return $this;
    }

    public function offsetExists($offset) : bool
    {
        return (bool)isset($this->configuration[$offset]);
    }

    public function offsetGet($offset) : ConfigurationInterface
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfBoundsException("Configuration {$offset} does not exists");
        }

        $config = $this->configuration[$offset];
        $configuration = (new ApplicationConfiguration())->set($offset, $config);
        return $configuration;
    }

    public function offsetSet($offset, $value) :  ConfigurationInterface
    {
        if (
            is_object($value) &&
            !$value instanceof ConfigurationInterface &&
            !$value instanceof \stdClass
        ) {
            $message = "Invalid type of object, Configurations should be an ";
            $message .= "object of type \\stdClass or Docean\\Configuration\\ConfigurationInterface ";
            $message .= "object of type %s passed as argument ";
            throw new \InvalidArgumentException(sprintf($message), get_class($value));
        }

        $this->configuration[$offset] = $value;
        $this->rewind();
        return $this;
    }

    public function offsetUnset($offset) : ConfigurationInterface
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