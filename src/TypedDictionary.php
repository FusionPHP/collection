<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\DictionaryInterface;
use Fusion\Collection\Exceptions\CollectionException;

class TypedDictionary extends Dictionary
{
    private $acceptedType;

    public function __construct(string $acceptedType, array $items = [])
    {
        if ($acceptedType == '')
        {
            $message = sprintf(
                '%s must be initialized with a full qualified class name of the instance type to accept',
                TypedDictionary::class
            );

            throw new CollectionException($message);
        }

        $this->acceptedType = $acceptedType;
        parent::__construct($items);
    }

    public function add(string $key, $value): DictionaryInterface
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::add($key, $value);
        return $this;
    }

    private function throwExceptionIfNotAcceptedType($object): void
    {
        if ($this->notAcceptedType($object))
        {
            $message = sprintf(
                'Unable to modify collection. Only instances of type "%s" are allowed. Type "%s" given.',
                $this->acceptedType,
                is_object($object) ? get_class($object) : gettype($object)
            );

            throw new CollectionException($message);
        }
    }

    private function notAcceptedType($value): bool
    {
        return ($value instanceof $this->acceptedType) == false || $value == null;
    }

    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::offsetSet($offset, $value);
    }
}