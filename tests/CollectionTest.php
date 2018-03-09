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
}