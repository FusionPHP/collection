<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use Fusion\Collection\CollectionFactory;
use Fusion\Collection\Dictionary;
use Fusion\Collection\TypedCollection;
use Fusion\Collection\TypedDictionary;
use PHPUnit\Framework\TestCase;

class CollectionFactoryTest extends TestCase
{
    public function testCreatingNewEmptyCollection()
    {
        $collection = CollectionFactory::newCollection();

        $this->assertEquals(0, count($collection));
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCreatingNewCollectionWithItems()
    {
        $collection = CollectionFactory::newCollection(
            [
                'foo',
                'bar'
            ]
        );

        $this->assertEquals(2, count($collection));
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCreatingNewEmptyTypedCollection()
    {
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class);

        $this->assertEquals(0, count($collection));
        $this->assertInstanceOf(TypedCollection::class, $collection);
    }

    public function testCreatingNewTypedCollectionWithItems()
    {
        $collection = CollectionFactory::newTypedCollection(
            CrashTestDummy::class,
            [
                new CrashTestDummy(),
                new CrashTestDummy()
            ]
        );

        $this->assertEquals(2, count($collection));
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testCreatingNewEmptyDictionary()
    {
        $dictionary = CollectionFactory::newDictionary();

        $this->assertEquals(0, count($dictionary));
        $this->assertInstanceOf(Dictionary::class, $dictionary);
    }

    public function testCreatingDictionaryWithItems()
    {
        $dictionary = CollectionFactory::newDictionary(
            [
                'foo' => 'bar',
                'baz' => 'qux'
            ]
        );

        $this->assertEquals(2, count($dictionary));
        $this->assertInstanceOf(Dictionary::class, $dictionary);
    }

    public function testCreatingNewEmptyTypedDictionary()
    {
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class);

        $this->assertEquals(0, count($dictionary));
        $this->assertInstanceOf(TypedDictionary::class, $dictionary);
    }

    public function testCreatingTypedDictionaryWithItems()
    {
        $dictionary = CollectionFactory::newTypedDictionary(
            CrashTestDummy::class,
            [
                'foo' => new CrashTestDummy(),
                'bar' => new CrashTestDummy()
            ]
        );

        $this->assertEquals(2, count($dictionary));
        $this->assertInstanceOf(Dictionary::class, $dictionary);
    }
}
