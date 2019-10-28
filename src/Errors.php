<?php


namespace Zen\Validation;

use Traversable;

class Errors implements \IteratorAggregate
{

    /**
     * @var array
     */
    private $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function toArray(): array
    {
        return $this->errors;
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $this->errors[$key];
        }
    }
    public function set(string $key, string $value)
    {
        $this->errors[$key] = $value;
        return new Errors($this->errors);
    }

    public function has(string $key)
    {
        return isset($this->errors[$key]);
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->errors);
    }
}
