<?php

namespace Criteria\Tests;

use Carbon\Carbon;
use Criteria\Criteria;
use Criteria\Transformers\Mongo;
use PHPUnit\Framework\TestCase;

class CriteriaMongoTest extends TestCase
{
    /** @test */
    public function transformation()
    {
        $criteria = Criteria::where()->a->eq('test')
            ->and->b->in('dvorak', 'qwerty')
            ->and(Criteria::where(Criteria::where()->c->gte(10)->and->c->lt(20))
                ->or->d->gte(Carbon::parse('2019-01-01', 'UTC'))
                ->or(Criteria::where()->e->gte(Carbon::parse('2019-01-01', 'UTC')))
            )
        ;
        $json = json_encode($criteria->transform(new Mongo()), JSON_PRETTY_PRINT);

        $expect = <<<'JSON'
{
    "$and": [
        {
            "a": {
                "$eq": "test"
            }
        },
        {
            "b": {
                "$in": [
                    "dvorak",
                    "qwerty"
                ]
            }
        },
        {
            "$or": [
                {
                    "$and": [
                        {
                            "c": {
                                "$gte": 10
                            }
                        },
                        {
                            "c": {
                                "$lt": 20
                            }
                        }
                    ]
                },
                {
                    "d": {
                        "$gte": {
                            "$date": {
                                "$numberLong": "1546300800000"
                            }
                        }
                    }
                },
                {
                    "e": {
                        "$gte": {
                            "$date": {
                                "$numberLong": "1546300800000"
                            }
                        }
                    }
                }
            ]
        }
    ]
}
JSON;
        $this->assertEquals($expect, $json);
    }

    /** @test */
    public function comparisonMethods()
    {
        $methods = [
            'in' => [1, 2, 3],
            'eq' => 1,
            'gt' => 2,
            'gte' => 3,
            'lt' => 4,
            'lte' => 5,
        ];

        foreach ($methods as $method => $value) {
            $criteria = Criteria::where()->$method->$method($value);
            $transformation = $criteria->transform(new Mongo());

            $this->assertArrayHasKey($method, $transformation);
            $this->assertArrayHasKey('$'. $method, $transformation[$method]);
            $this->assertEquals($value, $transformation[$method]['$'. $method]);
        }
    }

    /** @test */
    public function dateValue()
    {
        $criteria = Criteria::where()->date->eq(Carbon::parse('2019-01-01', 'UTC'));
        $transformation = $criteria->transform(new Mongo());

        $this->assertEquals(1546300800000, (string) $transformation['date']['$eq']);
    }
}