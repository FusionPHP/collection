<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\CollectionFactory;
use Fusion\Collection\Dictionary;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /** @var  Dictionary */
    private Dictionary $dictionary;

    private string $collectionException = CollectionException::class;

    public function setUp()
    {
        $this->dictionary = CollectionFactory::newDictionary();
    }

    public function tearDown()
    {
        unset($this->dictionary);
    }

    public function testAddingItemToDictionary()
    {
        $this->dictionary->add('foo', 'bar');

        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->count());
    }

    public function testCountingDictionaryWithCountable()
    {
        $this->dictionary->add('foo', 'bar');
        $this->assertEquals(1, count($this->dictionary));
    }

    public function testRemovingItemFromDictionary()
    {
        $this->dictionary->add('foo', 'bar');

        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->count());

        $this->dictionary->remove('bar');

        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->count());
    }

    public function testReplacingExistingItem()
    {
        $this->dictionary->add('foo', 'bar');
        $this->dictionary->replace('foo', 'quam');

        $expectedSize = 1;
        $expectedValue = 'quam';
        $this->assertEquals($expectedValue, $this->dictionary->find('foo'));
        $this->assertEquals($expectedSize, $this->dictionary->count());
    }

    public function testReplacingExistingItemViaOffset()
    {
        $this->dictionary->add('foo', 'bar');
        $expectedValue = 'baz';

        $this->dictionary['foo'] = 'baz';

        $this->assertEquals($expectedValue, $this->dictionary['foo']);
    }

    public function testExceptionThrownAddingNullItem()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->add('foo', null);
    }

    public function testExceptionThrownWhenKeyDoesNotExist()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->find('foo');
    }

    public function testIteratingOverDictionary()
    {
        $this->dictionary
            ->add('foo', 'bar')
            ->add('baz', 'quam')
            ->add('qux', 'flam');

        foreach ($this->dictionary as $key => $value) {
            $this->assertTrue($this->dictionary->valid());
        }
    }

    public function testExceptionThrownFindingValueWithKeyThatDoesNotExist()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->find('foo');
    }

    public function testExceptionThrownAccessingKeyThatDoesNotExist()
    {
        $this->expectException($this->collectionException);
        $this->dictionary['foo'];
    }

    public function testGettingValueAtGivenKey()
    {
        $key = 'foo';
        $expected = 'bar';
        $this->dictionary->add($key, $expected);
        $this->assertEquals($expected, $this->dictionary[$key]);
    }

    public function testSettingValueAtOffset()
    {
        $key = 'foo';
        $expected = 'bar';
        $this->dictionary[$key] = $expected;
        $this->assertEquals($expected, $this->dictionary->find($key));
    }

    public function testExceptionThrownGettingOffsetWithNonStringKey()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->add('foo', 'bar');
        $this->dictionary[0];
    }

    public function testExceptionThrownSettingValueWithNonStringKey()
    {
        $this->expectException($this->collectionException);
        $this->dictionary[0] = 'bar';
    }

    public function testRemovingItemAtOffset()
    {
        $this->dictionary->add('foo', 'bar');
        unset($this->dictionary['foo']);

        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->count());
    }

    public function testExceptionThrownReplacingExistingValueWithNullUsingMethod()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->add('foo', 'bar');
        $this->dictionary->replace('foo', null);
    }

    public function testExceptionThrownReplacingExistingValueWithNullUsingOffset()
    {
        $this->expectException($this->collectionException);
        $this->dictionary->add('foo', 'bar');
        $this->dictionary[0] = null;
    }

    public function testOffsetUnsetOnValidOffsetRemovesItemFromDictionary()
    {
        $this->dictionary->add('foo', 'bar');
        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->count());

        $offset = 'foo';
        unset($this->dictionary[$offset]);
        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->count());
    }

    public function testExceptionThrownAccessingOffsetOfEmptyDictionary()
    {
        $this->expectException($this->collectionException);
        $this->dictionary['foo'];
    }
}