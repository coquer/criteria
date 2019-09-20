<?php

namespace Criteria;

use Criteria\Interfaces\Transformer;

/**
 * Generel Criteria class. Create query Criteria in a fluent SQL style.
 *
 * An example can be found in the CriteriaTest class.
 *
 * @package App\Libraries\Criteria
 */
class Criteria extends Criterion
{
    protected $stack = [];
    protected $why = '?';

    /**
     * Criteria constructor.
     *
     * @param Criteria|null $criteria
     */
    public function __construct(Criteria $criteria = null)
    {
        if ($criteria) {
            $this->stack[] = $criteria;
        }
    }

    /**
     * Create a new Criteria instance. It is possible to add initial sub criteria to the new instance.
     *
     * @param Criteria|null $criteria
     * @return Criteria
     */
    public static function where(Criteria $criteria = null)
    {
        return new Criteria($criteria);
    }

    /**
     * Add nested Criteria or instantiate the current Criterion on the stack.
     *
     * @param string $method
     * @param $arguments
     * @return $this
     */
    public function __call(string $method, $arguments)
    {
        switch ($method) {
            case 'and':
            case 'or':
                $this->stack[] = $method;
                $this->stack[] = current($arguments);
                break;

            default:
                $this->stack[] = new Criterion(array_pop($this->stack), $method, $arguments);
        }

        return $this;
    }

    /**
     * Apply a transformer to the Criteria.
     *
     * Note that in case of multiple different operators (and/or), the last operator will be used.
     *
     * @param Transformer $transformer
     * @return mixed
     */
    public function transform(Transformer $transformer)
    {
        $operator = null;
        $result = [];

        foreach ($this->stack as $element) {
            if (is_object($element)) {
                $result[] = $element->transform($transformer);
            } else {
                $operator = $element;
            }
        }

        return !$operator ? current($result) : $transformer->$operator($result);
    }
}
