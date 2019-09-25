<?php

namespace Criteria\Interfaces;

interface Comparison extends Transformer
{
    /**
     * Build a Logical AND statement from all the filters in the result.
     * @param $result
     * @return mixed
     */
    public function and($result);

    /**
     * Build a Logical OR statement from all the filters in the result.
     * @param $result
     * @return mixed
     */
    public function or($result);

    /**
     * $key must equal the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function eq($key, $arguments);

    /**
     * $key must not equal the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function ne($key, $arguments);

    /**
     * $key must match one of the specified arguments.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function in($key, $arguments);

    /**
     * $key must not match any of the specified arguments.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function nin($key, $arguments);

    /**
     * $key must be greater than the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function gt($key, $arguments);

    /**
     * $key must be greater than or equal to the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function gte($key, $arguments);

    /**
     * $key must be less than the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function lt($key, $arguments);

    /**
     * $key must be less than or equal to the first argument.
     * @param $key
     * @param $arguments
     * @return mixed
     */
    public function lte($key, $arguments);

}
