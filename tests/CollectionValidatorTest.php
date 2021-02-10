<?php

/**
 * Part of the Fusion.Collection package test suite.
 *
 * @license MIT
 */

namespace Fusion\Collection\Tests;

use Fusion\Collection\Collection;
use Fusion\Collection\CollectionFactory;
use Fusion\Collection\CollectionValidator;
use Fusion\Collection\Contracts\CollectionValidationInterface;
use Fusion\Collection\Exceptions\CollectionException;
use PHPUnit\Framework\TestCase;
use stdClass;

class CollectionValidatorTest extends TestCase
{
    /** @var CollectionValidationInterface */
    private $validator;

    /** @var Collection */
    private Collection $collection;

    public function setUp()
    {
        $this->validator = new CollectionValidator();
        $this->collection = CollectionFactory::newCollection();
    }

    public function testExceptionThrownWhenValueIsNull()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateNonNullValue(null);
    }

    public function testNoExceptionThrownWhenValueIsNotNull()
    {
        $this->validator->validateNonNullValue('foo');
    }

    public function testExceptionThrownWhenOffsetDoesNotExist()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateOffsetExists(1, $this->collection);
    }

    public function testNoExceptionThrownWhenOffsetExists()
    {
        $this->collection->add('foo');
        $this->collection->add('bar');
        $this->validator->validateOffsetExists(1, $this->collection);
    }

    public function testExceptionThrownWhenOffsetIsNotAnInteger()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateIntValue('foo');
    }

    public function testNoExceptionThrownWhenOffsetIsAnInteger()
    {
        $this->validator->validateIntValue(1);
    }

    public function testExceptionThrownWhenOffsetIsNotAString()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateStringValue(1);
    }

    public function testNoExceptionThrownWhenOffsetIsAString()
    {
        $this->validator->validateStringValue('foo');
    }

    public function testExceptionThrownWhenAcceptedTypeIsEmpty()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateNonEmptyAcceptedType('');
    }

    public function testNoExceptionThrownWhenAcceptedTypeIsPopulated()
    {
        $this->validator->validateNonEmptyAcceptedType('foo');
    }

    public function testExceptionThrownWhenValueIsNotAcceptedType()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateValueIsAcceptedType(new stdClass(), CrashTestDummy::class);
    }

    public function testNoExceptionThrownWhenValueIsAcceptedType()
    {
        $this->validator->validateValueIsAcceptedType(new CrashTestDummy(), CrashTestDummy::class);
    }
}
