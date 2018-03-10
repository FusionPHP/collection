<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @var \Fusion\Collection\Collection
     */
    protected $collection;

    private $oobExceptionString = '\OutOfBoundsException';
    private $runtimeExceptionString = '\RuntimeException';

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
        $this->collection = new Collection([15, 'foo', 3.14, [], PHP_INT_MAX, new \stdClass()]);

        $expected = 6;
        $this->assertEquals($expected, $this->collection->size());
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

    public function testRemoveItems()
    {
        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());

        $removed = 'bar';
        $this->collection->remove($removed);

        $expected = 2;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testAddAndEmptyItems()
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

    public function testRemoveItemNotInCollectionDoesNothing()
    {
        $removed = 'quam';
        $this->collection->remove($removed);

        $expected = 3;
        $this->assertEquals($expected, $this->collection->size());
    }

    public function testFindingItemAtId()
    {
        $expected = 'foo';
        $this->collection->add($expected);
        $this->assertEquals($expected, $this->collection->findAt(0));
    }

    public function testExceptionThrowLookingForItemOutOfCollectionBounds()
    {
        $this->expectException($this->oobExceptionString);
        $this->collection->findAt(30);
    }

    public function testExceptionThrownRemovingItemNotInCollectionBounds()
    {
        $this->expectException($this->oobExceptionString);
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

    public function testExceptionThrownTraversingEmptyCollection()
    {
        $this->makeEmptyCollection();
        $this->expectException($this->oobExceptionString);
        $this->collection->current();
    }

    public function testExceptionThrownMovingToNextElementInEmptyCollection()
    {
        $this->makeEmptyCollection();
        $this->expectException($this->oobExceptionString);
        $this->collection->next();
    }

    public function testExceptionThrownWhenAccessingCurrentKeyOfEmptyCollection()
    {
        $this->makeEmptyCollection();
        $this->expectException($this->oobExceptionString);
        $this->collection->key();
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

    public function testExceptionThrownIfNonIntegerGivenAsOffsetExistsValue()
    {
        $this->expectException($this->runtimeExceptionString);
        $targetOffset = 'foo';

        $this->collection->offsetExists($targetOffset);
    }

    public function testExceptionThrownIfAccessingOffsetAndCollectionIsEmpty()
    {
        $this->expectException($this->oobExceptionString);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetExists($targetOffset);
    }

    public function testExceptionThrownIfAccessingOffsetThatDoesNotExist()
    {
        $this->expectException($this->oobExceptionString);
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
        $this->expectException($this->runtimeExceptionString);
        $targetOffset = 'foo';

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetAndCollectionIsEmpty()
    {
        $this->expectException($this->oobExceptionString);
        $this->makeEmptyCollection();
        $targetOffset = 0;

        $this->collection->offsetGet($targetOffset);
    }

    public function testExceptionThrownIfGettingOffsetThatDoesNotExist()
    {
        $this->expectException($this->oobExceptionString);
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
        $this->expectException($this->runtimeExceptionString);
        $newValue = 'quam';
        $targetOffset = 'qux';

        $this->collection[$targetOffset] = $newValue;
    }

    public function testExceptionThrownSettingOffsetValueWhenCollectionIsEmpty()
    {
        $this->expectException($this->oobExceptionString);
        $this->makeEmptyCollection();
        $newValue = 'quam';
        $targetOffset = 1;

        $this->collection[$targetOffset] = $newValue;
    }

    public function testUnsettingElementAtGivenOffset()
    {
        $targetOffset = 2;
        unset($this->collection[$targetOffset]);

        $this->assertNull($this->collection[$targetOffset]);
    }

    public function testExceptionThrownUnsettingGivenOffsetAndOffsetIsNotAnInteger()
    {
        $this->expectException($this->runtimeExceptionString);
        $targetOffset = 'quam';
        unset($this->collection[$targetOffset]);
    }

    public function testExceptionThrownUnsettingGivenOffsetAndCollectionIsEmpty()
    {
        $this->expectException($this->runtimeExceptionString);
        $this->makeEmptyCollection();
        $targetOffset = 1;
        unset($this->collection[$targetOffset]);
    }
}