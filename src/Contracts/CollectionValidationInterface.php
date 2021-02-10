<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection\Contracts;

use Fusion\Collection\Exceptions\CollectionException;

/**
 * Defines common methods used by collections to validate the integrity of input and operations.
 *
 * @since 2.0.0
 */
interface CollectionValidationInterface
{
    /**
     * Validates that the given `value` is null or throws a `CollectionException` otherwise.
     *
     * @param $value
     *
     * @throws CollectionException
     */
    public function validateNonNullValue($value): void;

    /**
     * Validates that a given `offset` exists in the given `collection` or throws a
     * `CollectionException` otherwise.
     *
     * @param $offset
     * @param AbstractCollection $collection
     *
     * @throws CollectionException
     */
    public function validateOffsetExists($offset, AbstractCollection $collection): void;

    /**
     * Validates that the given `value` is an integer or throws a `CollectionException` otherwise.
     *
     * @param $value
     *
     * @throws CollectionException
     */
    public function validateIntValue($value): void;

    /**
     * Validates that the given `value` is a string or throws a `CollectionException` otherwise.
     *
     * @param $value
     *
     * @throws CollectionException
     */
    public function validateStringValue($value): void;

    /**
     * Validates that the `acceptedType` (meant to be a fully qualified name) is not empty or
     * throws a`CollectionException` otherwise.
     *
     * @param string $acceptedType
     *
     * @throws CollectionException
     */
    public function validateNonEmptyAcceptedType(string $acceptedType): void;

    /**
     * Validates that the value given is an instance of the `acceptedType` (meant to be a fully
     * qualified name) or throws a `CollectionException` otherwise.
     *
     * @param $value
     * @param string $acceptedType
     *
     * @throws CollectionException
     */
    public function validateValueIsAcceptedType($value, string $acceptedType): void;
}