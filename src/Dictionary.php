<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\AbstractCollection;
use Fusion\Collection\Contracts\DictionaryInterface;
use Fusion\Collection\Exceptions\CollectionException;

/**
 * An implementation of a dictionary collection.
 *
 * A dictionary holds values in a key/value pair with the keys consisting of strings and the values
 * consisting of any value that can be stored in a PHP array that isn't `null`.
 *
 * Dictionaries are traversable and can be looped or accessed directly using array index notation.
 *
 * @since 1.0.0
 */
class Dictionary extends AbstractCollection implements DictionaryInterface
{
    /**
     * Creates a new `Dictionary` instance with an optional set of starter items.
     *
     * The initial items must be an associative array with string keys and values that are not
     * `null`.
     *
     * This constructor with throw a `CollectionException` if any of the starter items contain a
     * `null` value.
     *
     * @param array $items
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $key => $value)
        {
            $this->add($key, $value);
        }
    }

    /** {@inheritdoc} */
    public function add(string $key, $value): DictionaryInterface
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    /** {@inheritdoc} */
    public function replace(string $key, $value): DictionaryInterface
    {
        return $this->add($key, $value);
    }

    /** {@inheritdoc} */
    public function find(string $key)
    {
        $this->throwExceptionIfIdDoesNotExist($key);
        return $this->offsetGet($key);
    }

    /** {@inheritdoc} */
    protected function throwExceptionIfIdDoesNotExist(string $id): void
    {
        parent::throwExceptionIfOffsetDoesNotExist($id);
    }

    /**
     * Retrieves a value at the given offset.
     *
     * This method will throw a `CollectionException` if the given offset is not a string or if the
     * given offset does not exist in the collection.
     *
     * @see \Fusion\Collection\Contracts\AbstractCollection::offsetGet()
     *
     * @param mixed $offset
     *
     * @return mixed
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function offsetGet($offset)
    {
        $this->throwExceptionIfOffsetIsNotAString($offset);
        parent::throwExceptionIfOffsetDoesNotExist($offset);
        return parent::offsetGet($offset);
    }

    /**
     * Sets a value at the given offset.
     *
     * This method will throw a `CollectionException` if the offset is not a string or if the value
     * is `null`.
     *
     * @see \Fusion\Collection\Contracts\AbstractCollection::offsetSet()
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
        $this->throwExceptionIfOffsetIsNotAString($offset);
        parent::offsetSet($offset, $value);
    }

    private function throwExceptionIfOffsetIsNotAString($offset): void
    {
        if (is_string($offset) == false)
        {
            throw new CollectionException('Offset to access must be a string.');
        }
    }
}