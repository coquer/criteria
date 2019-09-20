<?php

namespace Criteria;

use Criteria\Interfaces\Transformer;

/**
 * This class is used to describe specific criterion.
 *
 * @package App\Libraries\Criterion
 */
class Criterion
{
    private $key = null;
    private $method = null;
    private $arguments = null;

    /**
     * Criterion constructor.
     * @param string $key
     * @param string $method
     * @param array $arguments
     */
    public function __construct(string $key, string $method, array $arguments)
    {
        $this->key = $key;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Add element to the stack. Return $this for to enable chaining.
     *
     * @param string $key
     * @return $this
     */
    public function __get(string $key)
    {
        $this->stack[] = $key;

        return $this;
    }

    /**
     * Apply a transformer to the Criterion.
     *
     * @param Transformer $transformer
     * @return mixed
     */
    public function transform(Transformer $transformer)
    {
        return $transformer->{$this->method}($this->key, $this->arguments);
    }
}

