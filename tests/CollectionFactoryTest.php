<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 5/22/2018
 * Time: 9:23 AM
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

    public function testCreatingNewEmptyTypedCollection()
    {
        $collection = CollectionFactory::newTypedCollection(CrashTestDummy::class);

        $this->assertEquals(0, count($collection));
        $this->assertInstanceOf(TypedCollection::class, $collection);
    }

    public function testCreatingNewEmptyDictionary()
    {
        $dictionary = CollectionFactory::newDictionary();

        $this->assertEquals(0, count($dictionary));
        $this->assertInstanceOf(Dictionary::class, $dictionary);
    }

    public function testCreatingNewEmptyTypedDictionary()
    {
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class);

        $this->assertEquals(0, count($dictionary));
        $this->assertInstanceOf(TypedDictionary::class, $dictionary);
    }
}
