## Criteria

Use this library to create agnostic query filters. This enables loose coupling between the business code and 
the underlying datasets.

### Basic criteria creation

Create a basic filter that will filter out any elements where the property a is not equal to 1:

```php
$criteria = Criteria::where()->a->eq(1);
```  

Create a filter with multiple requirements:

```php
$criteria = Criteria::where()->a->eq(1)
    ->and->b->gte(10)
    ->and->b->lt(20)
;
``` 
 
This filter will match on any of the criterion:

```php
$criteria = Criteria::where()->a->eq(1)
    ->or->b->lt(10)
    ->or->b->gt(20)
;
```  

Match on any of a list of multiple values. The list can either be provided as multiple arguments or as an 
array. The following two examples creates identical criterion:

```php
$criteria = Criteria::where()->a->in(1, 2, 3);

$criteria = Criteria::where()->a->in([1, 2, 3);
```

Nesting is required to mix and/or criteria:

```php
$criteria = Criteria::where(Criteria::where()->a->eq(1)->and->b->eq(3))
    ->or(Criteria::where()->c->lt(5)->or->c->gt(10))
;
``` 

If one of the elements is a single criterion, the initial criteria can be skipped:

```php
$criteria = Criteria::where()->a->eq(1)
    ->or(Criteria::where()->c->lt(5)->or->c->gt(10))
;
```  

### Transformation of criteria

Use a transformer to generate output the criteria in a specific format. For example use the Mongo transformer to 
generate a query filter for MongoDB\Collection::find():

```php
use Criteria\Transformers\Mongo;

$criteria->transform(new Mongo());
```  
