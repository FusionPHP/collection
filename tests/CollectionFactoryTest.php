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
use Fusion\Collection\TypedCollection;
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
}
