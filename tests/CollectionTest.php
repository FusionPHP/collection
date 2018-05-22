<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use Fusion\Collection\CollectionFactory;
use Fusion\Collection\CollectionValidator;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @var \Fusion\Collection\Collection */
    protected $collection;

    public function setUp()
    {
        $this->makeEmptyCollection();
        $this->addFooBarBaz();
    }
    public function tearDown()
    {
        $this->collection = null;
    }

    private function makeEmptyCollection()
    {
        $this->collection = CollectionFactory::newCollection();
    }

    private function addFooBarBaz()
    {
        $this->collection
            ->add('foo')
            ->add('bar')
            ->add('baz');
    }

    public function testSetupOnConstruct()
    {
        $this->collection = new Collection(
            new CollectionValidator(),
            [PHP_INT_MAX, 'foo', M_PI, [], fopen('php://memory', 'r'), new \stdClass(), function () {}]
        );

        $expected = 7;
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testExceptionThrownAddingNullValueDuringConstructor()
    {
        $this->expectException(CollectionException::class);
        $this->collection = CollectionFactory::newCollection([null]);
    }

    public function testAddItems()
    {
        $foo = 'foo';
        $bar = 'bar';
        $baz = 'baz';

        $this->makeEmptyCollection();

        $this->collection
            ->add($foo)
            ->add($bar)
            ->add($baz);

        $expected = 3;
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testCollectionSizeWithCountable()
    {
        $this->assertEquals(3, count($this->collection));
    }

    public function testReplaceItem()
    {
        $expected = 'quam';
        $this->collection->replace(1, $expected);
        $this->assertEquals($expected, $this->collection->find(1));
    }

    public function testRemovingItemShrinksCollectionSize()
    {
        $this->collection->remove('foo');

        $expected = 2;
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testIndexValuesUpdateWhenRemovingItems()
    {
        $expected = 3;
        $this->assertEquals($expected, $this->collection->count());

        while($this->collection->count() > 0)
        {
            $this->collection->removeAt(0);
        }

        $expected = 0;
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testRemoveItemNotInCollectionDoesNotAffectCollectionSize()
    {
        $this->collection->remove('quam');
        $this->assertEquals(3, $this->collection->count());
    }

    public function testFindingItemAtId()
    {
        $expected = 'foo';
        $this->collection->add($expected);
        $this->assertEquals($expected, $this->collection->find(0));
    }

    public function testExceptionThrownLookingForItemOutOfCollectionBounds()
    {
        $this->expectException(CollectionException::class);
        $this->collection->find(30);
    }

    public function testAccessCurrentElementPosition()
    {
        $expected = 'foo';
        $this->addFooBarBaz();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessNextElementPosition()
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testAccessCurrentKey()
    {
        $expected = 1;
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->key());
    }

    public function testCurrentElementIsValidReturnsTrue()
    {
        $this->addFooBarBaz();
        $this->assertTrue($this->collection->valid());
    }

    public function testCurrentElementIsValidReturnsFalse()
    {
        $this->makeEmptyCollection();
        $this->assertFalse($this->collection->valid());
    }

    public function testRewindingElementPosition()
    {
        $expected = 'bar';
        $this->addFooBarBaz();
        $this->collection->next();
        $this->assertEquals($expected, $this->collection->current());

        $expected = 'foo';
        $this->collection->rewind();
        $this->assertEquals($expected, $this->collection->current());
    }

    public function testEmptyingCollection()
    {
        $expected = 0;
        $this->collection->clear();
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testOffsetExistsInCollection()
    {
        $targetOffset = 2;
        $this->assertTrue(isset($this->collection[$targetOffset]));
    }

    public function testCheckOffsetOfExistingElementReturnsTrue()
    {
        $this->assertTrue(isset($this->collection[0]));
    }

    public function testCheckOffsetOfMissingElementReturnsFalse()
    {
        $this->makeEmptyCollection();
        $this->assertFalse(isset($this->collection[0]));
    }

    public function testCheckingIfEmptyCollectionIssetReturnsTrue()
    {
        $this->assertTrue(isset($this->collection));
    }

    public function testEmptyCallOnCollectionReturnsFalse()
    {
        $this->assertFalse(empty($this->collection));
    }

    public function testExceptionThrownIfAccessingOffsetThatDoesNotExist()
    {
        $this->expectException(CollectionException::class);
        $targetOffset = 3;

        $this->collection[$targetOffset];
    }

    public function testRetrievingOffsetFromCollection()
    {
        $expected = 'foo';
        $targetOffset = 0;

        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testRetrievingOffsetViaArrayAccessNotation()
    {
        $expected = 'bar';
        $targetOffset = 1;

        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testExceptionThrownIfNonIntegerGivenAsOffsetGetValue()
    {
        $this->expectException(CollectionException::class);
        $targetOffset = 'foo';

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetAndCollectionIsEmpty()
    {
        $this->expectException(CollectionException::class);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetThatDoesNotExist()
    {
        $this->expectException(CollectionException::class);
        $targetOffset = 3;

        $this->collection->offsetGet($targetOffset);
    }

    public function testSettingOffsetValueInCollection()
    {
        $expected = 'baz';
        $targetOffset = 2;
        $this->assertEquals($expected, $this->collection[$targetOffset]);

        $expected = 'quam';
        $this->collection[$targetOffset] = $expected;
        $this->assertEquals($expected, $this->collection[$targetOffset]);
    }

    public function testExceptionThrownSettingOffsetValueAndOffsetIsNotAnInteger()
    {
        $this->expectException(CollectionException::class);
        $newValue = 'quam';
        $targetOffset = 'qux';

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownSettingOffsetValueWhereOffsetDoesNotExist()
    {
        $this->expectException(CollectionException::class);
        $this->makeEmptyCollection();
        $newValue = 'quam';
        $targetOffset = 1;

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownAddingNullItemToCollection()
    {
        $this->expectException(CollectionException::class);
        $this->collection->add(null);
    }

    public function testExceptionThrownReplacingItemWithNull()
    {
        $this->expectException(CollectionException::class);
        $this->collection->replace(0, null);
    }

    public function testExceptionThrownSettingNullItemAtOffset()
    {
        $this->expectException(CollectionException::class);
        $this->collection->add('foo');
        $this->collection[0] = null;
    }

    public function testOffsetUnsetOnValidOffsetRemovesItemFromCollection()
    {
        $this->makeEmptyCollection();
        $this->collection->add('foo');
        $expected = 1;
        $this->assertEquals($expected, $this->collection->count());

        $offset = 0;
        unset($this->collection[$offset]);
        $expected = 0;
        $this->assertEquals($expected, $this->collection->count());
    }

    public function testUnsetCastOnValueHasNoEffectOnCollection()
    {
        $this->makeEmptyCollection();
        $offset = 0;
        $expectedSize = 1;
        $expectedValue = 'foo';
        $this->collection->add($expectedValue);

        $value = (unset)$this->collection[$offset];

        $this->assertNull($value);
        $this->assertEquals($expectedSize, $this->collection->count());
        $this->assertEquals($expectedValue, $this->collection[$offset]);
    }
}