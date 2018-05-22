<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\AbstractCollection;
use Fusion\Collection\Contracts\CollectionValidationInterface;
use Fusion\Collection\Exceptions\CollectionException;

class CollectionValidator implements CollectionValidationInterface
{
    public function validateNonNullValue($value): void
    {
        if ($value === null)
        {
            throw new CollectionException('Collection operations will not accept null values.');
        }
    }

    public function validateOffsetExists($offset, AbstractCollection $collection): void
    {
        if ($collection->offsetExists($offset) === false)
        {
            throw new CollectionException("The key or index '$offset' does not exist in the collection.");
        }
    }

    public function validateIntValue($value): void
    {
        if (is_int($value) === false)
        {
            $message = sprintf(
                'Collection offset type must be an integer. %s given.',
                gettype($value)
            );

            throw new CollectionException($message);
        }
    }

    public function validateStringValue($value): void
    {
        if (is_string($value) === false)
        {
            throw new CollectionException('Offset to access must be a string.');
        }
    }

    public function validateNonEmptyAcceptedType(string $acceptedType): void
    {
        if ($acceptedType == '')
        {
            throw new CollectionException('Accepted type string cannot be empty.');
        }
    }

    public function validateValueIsAcceptedType($value, string $acceptedType): void
    {
        if ($this->notAcceptedType($value, $acceptedType))
        {
            $message = sprintf(
                'Unable to modify collection. Only instances of type "%s" are allowed. Type "%s" given.',
                $acceptedType,
                is_object($value) ? get_class($value) : gettype($value)
            );

            throw new CollectionException($message);
        }
    }

    private function notAcceptedType($value, string $acceptedType)
    {
        return ($value instanceof $acceptedType) === false;
    }
}