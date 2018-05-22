<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionInterface;
use Fusion\Collection\Contracts\CollectionValidationInterface;

/**
 * An implementation of a type-specific collection.
 *
 * A type-specific collection holds values internally with a numeric index. Upon construction the
 * consumer of this class must specify the fully qualified name of a class or interface that this
 * collection will accept.  This collection will only hold values that have this type or a
 * `CollectionException` will be thrown.
 *
 * Type-specific collections are traversable and can be looped or accessed directly using array
 * index notation.
 *
 * @since 1.0.0
 */
class TypedCollection extends Collection
{
    private $acceptedType;

    /**
     * Creates a type-specific collection that will allow instances of the `acceptedType`.
     *
     * Optionally, an array of starter items of the `acceptedType` can also be provided. The
     * constructor will throw a `CollectionException` if an empty string is provided for
     * `acceptedType` or if any of the starter items are not an instance of the `acceptedType`.
     *
     * @param \Fusion\Collection\Contracts\CollectionValidationInterface $validator
     * @param string $acceptedType The fully qualified name of instances the collection will accept.
     * @param array $items A set of items to populate the collection with.
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function __construct(CollectionValidationInterface $validator, string $acceptedType, array $items = [])
    {
        $validator->validateNonEmptyAcceptedType($acceptedType);
        $this->acceptedType = $acceptedType;
        parent::__construct($validator, $items);
    }

    /**
     * Adds a value to the collection.
     *
     * This method will throw a `CollectionException` if the value is not an instance of the
     * `acceptedType`.
     *
     * @param mixed $value
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function add($value): CollectionInterface
    {
        $this->validator->validateValueIsAcceptedType($value, $this->acceptedType);
        return parent::add($value);
    }

    /**
     * Replaces a value in the collection at the given key.
     *
     * This method will throw a `CollectionException` if the value give is not an instance of the
     * `acceptedType`.
     *
     * @param int $key
     * @param mixed $value
     *
     * @return \Fusion\Collection\Contracts\CollectionInterface
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function replace(int $key, $value): CollectionInterface
    {
        $this->validator->validateValueIsAcceptedType($value, $this->acceptedType);
        return parent::replace($key, $value);
    }

    /**
     * Sets a value at the given offset.
     *
     * This method will throw a `CollectionException` if the value is not an instance of the
     * accepted type, if the offset does not exist, or if the offset is not an integer.
     *
     * @see \Fusion\Collection\Collection::offsetSet()
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
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
        $this->validator->validateValueIsAcceptedType($value, $this->acceptedType);
        parent::offsetSet($offset, $value);
    }
}