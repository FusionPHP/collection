<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 4/22/2016
 * Time: 10:30 AM
 */

namespace Fusion\Collection\Tests;


use Fusion\Collection\Dictionary;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /** @var  Dictionary */
    private $dictionary;

    public function setUp()
    {
        $this->dictionary = new Dictionary();
    }

    public function tearDown()
    {
        unset($this->dictionary);
    }

    public function testInsertItemWithStringKey()
    {
        $this->dictionary->insert('foo', 'bar');
        $this->assertEquals('bar', $this->dictionary->getItem('foo'));
        $this->assertEquals(1, $this->dictionary->getSize());
    }

    public function testInsertItemWithIntKey()
    {
        $this->dictionary->insert(5, 'foo');
        $this->assertEquals('foo', $this->dictionary->getItem(5));
        $this->assertEquals(1, $this->dictionary->getSize());
    }

    public function testOverwriteItem()
    {
        $this->dictionary->insertAt('foo', 'bar');
        $this->assertEquals('bar', $this->dictionary->getItem('foo'));
        $this->dictionary->insertAt('foo', 'baz');
        $this->assertEquals('baz', $this->dictionary->getItem('foo'));
        $this->assertEquals(1, $this->dictionary->getSize());
    }

    public function testRemovingItemByValue()
    {
        $this->dictionary->insert('foo', 'bar');
        $this->dictionary->remove('bar');
        $this->assertEquals(0, $this->dictionary->getSize());
    }

    public function testRemovingItemByKey()
    {
        $this->dictionary->insert('foo', 'bar');
        $this->dictionary->removeAt('foo');
        $this->assertEquals(0, $this->dictionary->getSize());
    }

    public function testRemoveMultipleItemsByValue()
    {
        $this->dictionary->insert(1, 'bar');
        $this->dictionary->insert(2, 'bar');
        $this->dictionary->insert(3, 'bar');
        $this->dictionary->insert(4, 'baz');
        $this->dictionary->insert(5, 'qux');
        $this->assertEquals(5, $this->dictionary->getSize());
        $this->dictionary->remove('bar');
        $this->assertEquals(2, $this->dictionary->getSize());
        $this->assertEquals('baz', $this->dictionary->getItem(4));
        $this->assertEquals('qux', $this->dictionary->getItem(5));
    }

    public function testRemoveOnlyRemoveOneReference()
    {
        $value = null;
        for($i = 0; $i < 5; ++$i)
        {
            $value = new \stdClass();
            $this->dictionary->insert($i, $value);
        }
        $this->assertEquals(5, $this->dictionary->getSize());
        $this->dictionary->remove($value);
        $this->assertEquals(4, $this->dictionary->getSize());
        $this->expectException('\OutOfBoundsException');
        $this->dictionary->getItem(4);
        
    }

    public function testTraversingDictionary()
    {
        $this->dictionary->insert('foo', 'bar')
                         ->insert('baz', 'bim')
                         ->insert('bap', 'qux');

        foreach($this->dictionary as $key => $value)
        {
            if ($key == 'foo')
            {
                $this->assertEquals('bar', $value);
            }

            if ($key == 'baz')
            {
                $this->assertEquals('bim', $value);
            }

            if ($key == 'bap')
            {
                $this->assertEquals('qux', $value);
            }
        }
    }

    public function badKeyDataProvider()
    {
        return [
            [false],
            [true],
            [new \stdClass()],
            [null],
            [[]],
            [3.14]
        ];
    }

    /**
     * @dataProvider badKeyDataProvider
     */
    public function testInsertWithBadKey($data)
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->insert($data, 'foo');
    }

    /**
     * @dataProvider badKeyDataProvider
     */
    public function testInsertAtWithBadKey($data)
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->insert($data, 'foo');
    }

    public function testInsertWithBadItem()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->insert('foo', null);
    }

    public function testInsertAtWithBadItem()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->insertAt('foo', null);
    }

    /**
     * @dataProvider  badKeyDataProvider
     */
    public function testRemoveAtWithBadKey($data)
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->removeAt($data);
    }

    public function testRemoveWithBadItem()
    {
        $this->expectException('\InvalidArgumentException');
        $this->dictionary->remove(null);
    }

    public function testExceptionOnInsertOverwrite()
    {
        $this->expectException('\RuntimeException');
        $this->dictionary->insert('foo', 'bar');
        $this->dictionary->insert('foo', 'bar');
        $this->assertEquals(1, $this->dictionary->getSize());
    }

    public function testExceptionKeyNotExists()
    {
        $this->expectException('\OutOfBoundsException');
        $this->dictionary->getItem('foo');
    }
}