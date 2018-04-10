<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\DictionaryInterface;
use Fusion\Collection\Exceptions\CollectionException;

/**
 * An implementation of a type-specific dictionary collection.
 *
 * A type-specific dictionary holds values in a key/value pairs. Upon construction the consumer of
 * this class must specify the fully qualified name of a class or interface that this collection
 * will accept. This collection will only hold values that have this type or a `CollectionException`
 * will be thrown.
 *
 * Type-specific dictionaries are traversable and can be looped or accessed directly using array
 * index notation.
 *
 * @since 1.0.0
 */
class TypedDictionary extends Dictionary
{
    private $acceptedType;

    /**
     * Creates a new `TypedDictionary` instance with an optional set of starter items.
     *
     * The initial items must be an associative array with string keys and values that are instances
     * of the `acceptedType`. The constructor will throw a `CollectionException` if an empty string
     * is provided for `acceptedType` or if any of the starter items are not an instance of the
     * `acceptedType`.
     *
     * @param string $acceptedType The fully qualified name of instances the collection will accept.
     * @param array $items A set of items to populate the collection with.
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function __construct(string $acceptedType, array $items = [])
    {
        if ($acceptedType == '')
        {
            $message = sprintf(
                '%s must be constructed with a fully qualified class or interface name of the instance type to accept.',
                TypedDictionary::class
            );

            throw new CollectionException($message);
        }

        $this->acceptedType = $acceptedType;
        parent::__construct($items);
    }

    /**
     * Adds a value to the collection at the given key offset.
     *
     * This method will throw a `CollectionException` if the value given is not an instance of the
     * `acceptedType`.
     *
     * @see \Fusion\Collection\Dictionary::add()
     *
     * @param string $key
     * @param $value
     *
     * @return \Fusion\Collection\Contracts\DictionaryInterface
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
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
        return ($value instanceof $this->acceptedType) === false;
    }

    /**
     * Sets a value at the given offset.
     *
     * This method will throw a `CollectionException` if the offset is not a string or if the value
     * is not an instance of the `acceptedType`.
     *
     * @see \Fusion\Collection\Dictionary::offsetSet()
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::offsetSet($offset, $value);
    }
}