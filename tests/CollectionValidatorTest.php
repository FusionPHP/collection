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

    public function setUp(): void
    {
        $this->validator = new CollectionValidator();
        $this->collection = CollectionFactory::newCollection();
    }

    public function testExceptionThrownWhenValueIsNull()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateNonNullValue(null);
    }

    public function testExceptionThrownWhenOffsetDoesNotExist()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateOffsetExists(1, $this->collection);
    }

    public function testExceptionThrownWhenOffsetIsNotAnInteger()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateIntValue('foo');
    }

    public function testExceptionThrownWhenOffsetIsNotAString()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateStringValue(1);
    }

    public function testExceptionThrownWhenAcceptedTypeIsEmpty()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateNonEmptyAcceptedType('');
    }

    public function testExceptionThrownWhenValueIsNotAcceptedType()
    {
        $this->expectException(CollectionException::class);
        $this->validator->validateValueIsAcceptedType(new stdClass(), CrashTestDummy::class);
    }
}
