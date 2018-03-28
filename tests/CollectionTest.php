<?php

/**
 * Part of the Fusion.Collection test suite.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use Fusion\Collection\Contracts\AbstractCollection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @var \Fusion\Collection\Collection
     */
    protected $collection;

    private $outOfBoundsException = \OutOfBoundsException::class;
    private $invalidArgumentException = \InvalidArgumentException::class;

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
        $this->collection = new Collection();
    }

    private function addFooBarBaz()
    {
        $this->collection->add('foo');
        $this->collection->add('bar');
        $this->collection->add('baz');
    }

    public function testSetupOnConstruct()
    {
        $this->collection = new Collection([PHP_INT_MAX, 'foo', M_PI, [], fopen('php://memory', 'r'), new \stdClass(), function () {}]);

        $this->assertTrue(is_int($this->collection[0]));
        $this->assertTrue(is_string($this->collection[1]));
        $this->assertTrue(is_float($this->collection[2]));
        $this->assertTrue(is_array($this->collection[3]));
        $this->assertTrue(is_resource($this->collection[4]));
        $this->assertTrue(is_object($this->collection[5]));
        $this->assertTrue(is_callable($this->collection[6]));

        $expected = 7;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testExceptionThrownAddingNullValueDuringContructor()
    {
        $this->expectException($this->invalidArgumentException);
        $this->collection = new Collection([null]);
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
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testRemovingItemReturnsTrue()
    {
        $removed = 'foo';
        $this->assertTrue($this->collection->remove($removed));

        $expected = 2;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testIndexValuesUpdateWhenRemovingItems()
    {
        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());

        while($this->collection->size() > 0)
        {
            $this->collection->removeAt(0);
        }

        $expected = 0;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testRemoveItemNotInCollectionReturnsFalse()
    {
        $removed = 'quam';
        $this->assertFalse($this->collection->remove($removed));
    }

    public function testFindingItemAtId()
    {
        $expected = 'foo';
        $this->collection->add($expected);
        $this->assertEquals($expected, $this->collection->findAt(0));
    }

    public function testExceptionThrownLookingForItemOutOfCollectionBounds()
    {
        $this->expectException($this->outOfBoundsException);
        $this->collection->findAt(30);
    }

    public function testExceptionThrownRemovingItemNotInCollectionBounds()
    {
        $this->expectException($this->outOfBoundsException);
        $this->collection->removeAt(30);
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
        $this->assertEquals($expected, $this->collection->size());
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
        $this->expectException($this->outOfBoundsException);
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
        $this->expectException($this->invalidArgumentException);
        $targetOffset = 'foo';

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetAndCollectionIsEmpty()
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetThatDoesNotExist()
    {
        $this->expectException($this->outOfBoundsException);
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
        $this->expectException($this->invalidArgumentException);
        $newValue = 'quam';
        $targetOffset = 'qux';

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownSettingOffsetValueWhereOffsetDoesNotExist()
    {
        $this->expectException($this->outOfBoundsException);
        $this->makeEmptyCollection();
        $newValue = 'quam';
        $targetOffset = 1;

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownAddingNullItemToCollection()
    {
        $this->expectException($this->invalidArgumentException);
        $this->collection->add(null);
    }

    public function testExceptionThrownSettingNullItemAtOffset()
    {
        $this->expectException($this->invalidArgumentException);
        $this->collection->add('foo');
        $this->collection[0] = null;
    }

    public function testOffsetUnsetOnValidOffsetRemovesItemFromCollection()
    {
        $this->makeEmptyCollection();
        $this->collection->add('foo');
        $expected = 1;
        $this->assertEquals($expected, $this->collection->size());

        $offset = 0;
        unset($this->collection[$offset]);
        $expected = 0;
        $this->assertEquals($expected, $this->collection->size());
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
        $this->assertEquals($expectedSize, $this->collection->size());
        $this->assertEquals($expectedValue, $this->collection[$offset]);
    }
}