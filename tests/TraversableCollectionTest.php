<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\TraversableCollection;
use PHPUnit\Framework\TestCase;

class TraversableCollectionTest extends TestCase
{
    /**
     * Test collection instance
     *
     * @var \Fusion\Collection\TraversableCollection
     */
    protected $collection;


    public function setUp()
    {
        $this->collection = new TraversableCollection();
        $this->collection->add('foo');
        $this->collection->add('bar');
        $this->collection->add('baz');
    }

    public function tearDown()
    {
        $this->collection = null;
    }

    public function testCurrentAndRewinding()
    {
        $this->collection->next();
        $this->assertEquals('bar', $this->collection->current());
        $this->collection->rewind();
        $this->assertEquals('foo', $this->collection->current());
    }

    public function testGettingKey()
    {
        $this->assertEquals(0, $this->collection->key());
        $this->collection->next();
        $this->assertEquals(1, $this->collection->key());
    }

    public function testIsValid()
    {
        $this->assertTrue($this->collection->valid());
    }

    public function testIsNotValid()
    {
        $this->collection = new TraversableCollection();
        $this->assertFalse($this->collection->valid());
    }

}