<?php

namespace Criteria\Transformers;

use \Datetime;
use Criteria\Interfaces\Comparison;
use MongoDB\BSON\UTCDatetime;


class Mongo implements Comparison
{
    protected function transform($arguments)
    {
        foreach ($arguments as $index => $argument) {
            if ($argument instanceof DateTime) {
                $arguments[$index] = new UTCDatetime($argument->getTimestamp() * 1000);
            }
        }

        return $arguments;
    }

    public function and($result)
    {
        return ['$' . __FUNCTION__ => $result];
    }

    public function or($result)
    {
        return ['$' . __FUNCTION__ => $result];
    }

    public function in($key, $arguments)
    {
        if (is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return [$key => ['$in' => $this->transform($arguments)]];
    }

    public function nin($key, $arguments)
    {
        if (is_array(current($arguments))) {
            $arguments = current($arguments);
        }

        return [$key => ['$nin' => $this->transform($arguments)]];
    }

    public function eq($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }

    public function ne($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }

    public function gt($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }

    public function gte($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }

    public function lt($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }

    public function lte($key, $arguments)
    {
        return [$key => ['$' . __FUNCTION__ => current($this->transform($arguments))]];
    }
}
