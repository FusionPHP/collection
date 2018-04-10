<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Dictionary;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /** @var  Dictionary */
    private $dictionary;

    private $collectionException = CollectionException::class;

    public function setUp()
    {
        $this->dictionary = new Dictionary();
    }

    public function tearDown()
    {
        unset($this->dictionary);
    }

    public function testAddingItemToDictionary()
    {
        $this->dictionary->add('foo', 'bar');

        $expected = 1;
        $this->assertEquals($expected, $this->dictionary->size());
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
        $this->assertEquals($expected, $this->dictionary->size());

        $this->dictionary->remove('bar');

        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->size());
    }

    public function testReplacingExistingItem()
    {
        $this->dictionary->add('foo', 'bar');
        $this->dictionary->replace('foo', 'quam');

        $expectedSize = 1;
        $expectedValue = 'quam';
        $this->assertEquals($expectedValue, $this->dictionary->find('foo'));
        $this->assertEquals($expectedSize, $this->dictionary->size());
    }

    public function testReplacingExisitingItemViaOffset()
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

        foreach ($this->dictionary as $key => $value)
        {
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
        $this->assertEquals($expected, $this->dictionary->size());
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
        $this->assertEquals($expected, $this->dictionary->size());

        $offset = 'foo';
        unset($this->dictionary[$offset]);
        $expected = 0;
        $this->assertEquals($expected, $this->dictionary->size());
    }

    public function testUnsetCastOnValueHasNoEffectOnDictionary()
    {
        $offset = 'key';
        $expectedSize = 1;
        $expectedValue = 'bar';
        $this->dictionary->add($offset, $expectedValue);

        $value = (unset)$this->dictionary[$offset];

        $this->assertNull($value);
        $this->assertEquals($expectedSize, $this->dictionary->size());
        $this->assertEquals($expectedValue, $this->dictionary[$offset]);
    }

    public function testExceptionThrownAccessingOffsetOfEmptyDictionary()
    {
        $this->expectException($this->collectionException);
        $this->dictionary['foo'];
    }
}