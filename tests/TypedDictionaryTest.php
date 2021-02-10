<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\CollectionFactory;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;
use stdClass;

class TypedDictionaryTest extends TestCase
{
    public function testCreateTypedDictionary()
    {
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class);
        $dictionary->add('foo', new CrashTestDummy());
        $this->assertEquals(1, $dictionary->count());
    }

    public function testExceptionThrownCreatingDictionaryWithEmptyStringForClassName()
    {
        $this->expectException(CollectionException::class);
        CollectionFactory::newTypedDictionary('');
    }

    public function testCreatingDictionaryWithItems()
    {
        $items = [
            'foo' => new CrashTestDummy(),
            'bar' => new CrashTestDummy()
        ];
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class, $items);
        $this->assertEquals(2, $dictionary->count());
    }

    public function testExceptionThrownCreatingDictionaryWithBadValue()
    {
        $this->expectException(CollectionException::class);
        $items = ['foo' => new stdClass()];
        CollectionFactory::newTypedDictionary(CrashTestDummy::class, $items);
    }

    public function testExceptionThrownSendingNullValue()
    {
        $this->expectException(CollectionException::class);
        $items = ['foo' => null];
        CollectionFactory::newTypedDictionary(CrashTestDummy::class, $items);
    }

    public function testExceptionThrownReplacingValueWithNull()
    {
        $this->expectException(CollectionException::class);
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class, ['crash' => new CrashTestDummy()]);
        $dictionary->replace('crash', null);
    }

    public function testExceptionThrownReplacingValueWithIncorrectType()
    {
        $this->expectException(CollectionException::class);
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class, ['crash' => new CrashTestDummy()]);
        $dictionary->replace('crash', new stdClass());
    }

    public function testExceptionThrownSettingOffsetWithNullValue()
    {
        $this->expectException(CollectionException::class);
        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class);
        $dictionary['foo'] = new stdClass();
    }

    public function testSettingValueAtOffset()
    {
        $first = new CrashTestDummy();
        $second = new CrashTestDummy();

        $dictionary = CollectionFactory::newTypedDictionary(CrashTestDummy::class);
        $dictionary['foo'] = $first;

        $this->assertEquals(1, $dictionary->count());

        $dictionary['foo'] = $second;

        $this->assertEquals(1, $dictionary->count());
        $this->assertSame($second, $dictionary->find('foo'));
    }

}
