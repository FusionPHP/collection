# Fusion.Collection
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FusionPHP/collection/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FusionPHP/collection/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/FusionPHP/collection/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/FusionPHP/collection/?branch=master)
[![Build Status](https://travis-ci.org/FusionPHP/collection.svg?branch=master)](https://travis-ci.org/FusionPHP/collection)

This package provides a small collection library useful for aggregating data values in an object.
Stored values can be accessed via methods, loops, or as an array.

## Requirements
PHP 7.4 or greater.

## Installation

This package is installed via Composer.

```
composer require fusion-php/collection
```
## Usage

The library provides two different types of a collection. A basic object, simply `Collection`, 
and a `Dictionary`.  There are two variants of these called `TypedCollection` and `TypedDictionary`
which are meant for storing instances of specific object types.

### Instantiation

Creating any of the collection objects this library provides can be done via constructor or with
the `CollectionFactory` class. The remainder of this section will assume the usage of the
`CollectionFactory` class to create collection objects. For information about instantiation via
constructor please see the [Manual Instantiation](#manual_instantiation) section below.

### The Collection Class

The `Collection` object will hold any value that a PHP array can hold, with the exception of `null` 
values.

A `Collection` can be instantiated empty or with an array of starting elements. In the latter 
scenario existing keys in the array are ignored.

```php
<?php

namespace App;

use Fusion\Collection\CollectionFactory;

require '../vendor/autoload.php';

$collection = CollectionFactory::newCollection(); //empty

// ... or ...

$items = ['foo', 'bar', 'baz'];    
$collection = CollectionFactory::newCollection($items);

var_dump($collection->count()); //int (3)
```

As seen above, the `count()` method returns an integer with the number of items in the collection.
The collection utilizes the [Countable](http://php.net/manual/en/countable.count.php) interface
allowing you to obtain the collection size via the PHP `count()` method as an alternative means.

```php
$size = count($collection); //same as $size = $collection->count();
```

To add items to the collection use the `add()` method passing in the value you wish to store.

```php
$collection->add(42);
```
    
Use the `find()` method with an existing index to retrieve a value from the collection.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);
var_dump($collection->find(1)); //string 'bar'
```

The collection can have values replaced by calling the `replace()` method and providing the index
of the value to be replaced and the replacement value.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);
$collection->replace(1, 'bam'); //Collection is now ['foo', 'bam', 'baz']
```

To remove items from the collection use the `remove()` method passing in the value to remove.

```php 
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);
$collection->remove('foo'); //count() == 2
```

With the `remove()` method all values *identical* to the argument given are removed. This means 
that any duplicates of literal values or objects of the *same* instance are also removed. To remove 
a specific value use the `removeAt()` method passing in the numerical index of the value's location.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);
$collection->removeAt(1); //Collection is now [0 => 'foo', 1 => 'baz');
```
    
Both the `remove()` and `removeAt()` methods will cause the numerical index of the collection to
update closing any gaps in the index sequence. 

To empty out a collection simply call the `clear()` method.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);
$collection->clear();
var_dump($collection->count()); //int (0)
```

#### Iteration and Direct Access

The `Collection` instances can make use of [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)
and [Iterator](http://php.net/manual/en/class.iterator.php). This means that you can use a 
collection as the subject of a `for` or `foreach`.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);

for ($i = 0; $i < count($collection); $i++)
{
    //... do something with $collection[$i];
}

// ... or ...

foreach ($collection as $key => $value)
{
    //... do something with $key and/or $value
}
```
You can also access items and replace items directly via their index if they already exist.

```php
$collection = CollectionFactory::newCollection(['foo', 'bar', 'baz']);

var_dump($collection[2]); //string 'baz'
$collection[2] = 'qux'; //same as calling $collection->replace(2, 'qux');
```

Feel free to remove items in this way via an `unset()` call with a value's index number.

```php
unset($collection[3]); //same as calling $collection->removeAt(3);
```
    
### The Dictionary Class

A `Dictionary` is very similar to a `Collection` with the main difference being that a `Dictionary`
only accepts index values (called keys from here on) as strings. A `Dictionary` will hold any value 
that a PHP array can hold, with the exception of `null` values.

A `Dictionary` can be instantiated empty or with an array of starting elements. In the latter 
scenario existing keys in the array are not ignored, but they must be strings.

```php
<?php

namespace App;

use Fusion\Collection\CollectionFactory;

require '../vendor/autoload.php';

$dictionary = CollectionFactory::newDictionary(); //empty

// ... or ...

$items = ['foo' => 'bar', 'baz' => 'bam'];    
$dictionary = CollectionFactory::newDictionary($items);

var_dump($dictionary->count()); //int (2)
```

As seen above the `count()` method can be used to gather the number of items in the dictionary and,
as with the `Collection` class, this can also be obtained using the PHP `count()` method.

```php
$size = count($dictionary); //same as $size = $dictionary->count();
```
    
Items can be added to the dictionary with the `add()` method specifying the key to store them under.

```php
$dictionary->add('foo', 'bar');
```
    
Items can be replaced at a given key as well.

```php
$dictionary->replace('foo', 'bam');
```
    
The `find()`, `remove()`, `removeAt()`, and `clear()` methods in the `Dictionary` class work exactly
the same as they do under the `Collection` class, with the `find()` and `removeAt()` methods 
requiring their parameters to be strings instead of integers.

#### Iteration and Direct Access

The `Dictionary` class also leverages the [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)
and [Iterator](http://php.net/manual/en/class.iterator.php) interfaces allowing looping.

```php
$dictionary = CollectionFactory::newDictionary(['foo1' => 'bar', 'foo2' => 'bam']);

for ($i = 1; $i <= count($dictionary); $i++)
{
    // ... do something with $dictionary['foo' . $i];
}

// ... or ...

foreach ($dictionary as $key => $value)
{
    // ... do something with $key and/or $value
}
```

The values in a `Dictionary` can also be accessed directly via their key offset.

```php
$dictionary = CollectionFactory::newDictionary(['foo' => 'bar', 'baz' => 'bam']);
var_dump($dictionary['baz']); //string 'bam'
```

Removing an item directly can be done with `unset()`.

```php
unset($dictionary['foo']); // same as calling $dictionary->removeAt('foo');
```

Values can also be replaced directly at their offset and in addition new items can be added directly
at their offset.

```php
$dictionary['foo'] = 'bar'; 
// same as calling $dictionary->add('foo', 'bar'); or $dictionary->replace('foo', 'bar');
```
          
### The TypedCollection and TypedDictionary Classes

In certain cases it may be desired to have a collection or dictionary that stores only object
references of a specific type. In these cases a `TypedCollection` or `TypedDictionary` may be used.

Both classes are children of the `Collection` and `Dictionary` classes, respectively, and can be
constructed with an optional set of starter items. However, the only required parameter during
instantiation is the *fully qualified name* of the class or interface that is acceptable.

```php
<?php

namespace App;

use Fusion\Collection\CollectionFactory;

require '../vendor/autoload.php';

class Apple { /* ... */ }

$apples = CollectionFactory::newTypedCollection(Apple::class);

//Only instances of Apple are allowed
$apples->add(new Apple())
       ->add(new Apple())
       ->add(new Apple());

var_dump(count($apples)); //int (3)

// ... or ...

$setOfApples = [new Apple(), new Apple(), new Apple()];
$apples = CollectionFactory::newTypedCollection(Apple::class, $setOfApples);
var_dump(count($apples)); //int (3)
```

The `TypedDictionary` variant is similar, however string keys are required.

```php
<?php
    
namespace App;
    
use Fusion\Collection\CollectionFactory;

require '../vendor/autoload.php';

interface AppleInterface { /* ... */ }

class RedDelicious implements AppleInterface { /* ... */ }
class GrannySmith implements AppleInterface { /* ... */ }
class Gala implements AppleInterface { /* ... */ }

$appleBasket = CollectionFactory::newTypedDictionary(AppleInterface::class);

$appleBasket->add('redDelicious', new RedDelicious())
            ->add('grannySmith', new GrannySmith())
            ->add('gala', new Gala());
```

As with the standard `Collection` and `Dictionary` classes, `null` values are not allowed.

### Exception Cases

The library defines the exception `CollectionException`, which is thrown in the following cases:

#### `Collection`

- Adding a `null` value.
- Replacing an existing value with `null`.
- Using `find()` with an index that is not in the collection.
- Accessing an index directly that does not exist.
- Accessing an index that is not an integer.

#### `TypedCollection`

- Same conditions as `Collection` apply.
- Adding an instance to the collection (or replacing) that does not match the accepted type.

#### `Dictionary`

- Adding a `null` value.
- Replacing an existing value with `null`.
- Using `find()` with a key that is not in the collection.
- Accessing a key directly that does not exist.
- Accessing a key that is not a string.

#### `TypedDictionary`

- Same conditions as `Dictionary` apply.
- Adding an instance to the dictionary (or replacing) that does not match the accepted type.

### <a name="manual_instantiation"></a>Manual Instantiation

Each of the collection objects in this library can be instantiated manually using their constructor
versus the `CollectionFactory` class. The constructor signatures are similar to those found in the
factory versions with the exception of an added parameter, an instance of the 
`CollectionValidationInterface`, which takes care of integrity checks for collection operations.

Each of the constructor signatures are as follows:

- `Collection::__construct(CollectionValidationInterface $validator, array $items = []);`
- `Dictionary::__construct(CollectionValidationInterface $validator, array $items = []);`
- `TypedCollection::__construct(CollectionValidationInterface $validator, string $acceptedType, array $items = []);`
- `TypedDictionary::__construct(CollectionValidationInterface $validator, string $acceptedType, array $items = []);`

The library provides an implementation of the `CollectionValidationInterface` in the form of the
`CollectionValidator` class. Below is the alternative method of creating collection objects:

```php
<?php

namespace App;

use Fusion\Collection\Collection;
use Fusion\Collection\CollectionValidator;

require '../vendor/autoload.php';

$validator = new CollectionValidator();
$collection = new Collection($validator, ['foo', 'bar', 'baz']);

var_dump(count($collection)); //int (3)
```

The above pattern holds true for the remaining collection objects. Simply create an instance of the
`CollectionValidationInterface` and pass it as the first parameter to the constructor.