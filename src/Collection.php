<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionInterface;
use ArrayAccess;
use Iterator;
use OutOfBoundsException;
use InvalidArgumentException;

/**
 * A basic collection class.
 *
 * This collection class is capable of aggregating any value that can be stored in a PHP array.
 * Items in the collection may be accessed by using the appropriate methods or by treating the
 * instance as an array and accessing the items via an index number. The collection is also
 * traversable and may be used in `foreach` loops.
 *
 * @since 1.0.0
 */
class Collection implements CollectionInterface, Iterator, ArrayAccess
{
    private $collection = [];

    /**
     * Instantiates a collection object with an optional array of starter items.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item)
        {
            $this->add($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function add($collectable): CollectionInterface
    {
        array_push($this->collection, $collectable);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($collectable): bool
    {
        $position = $this->has($collectable);

        if ($position >= 0)
        {
            return $this->removeAt($position);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAt(int $id): bool
    {
        $this->throwExceptionIfIdDoesNotExist($id);
        array_splice($this->collection, $id, 1);

        return true;
    }

    private function throwExceptionIfIdDoesNotExist(int $id): void
    {
        if ($this->idExists($id) === false)
        {
            throw new OutOfBoundsException("The id '$id' doesn't exist in the collection.");
        }
    }

    private function idExists(int $id): bool
    {
        return array_key_exists($id, $this->collection);
    }

    private function has($collectable): int
    {
        foreach ($this->collection as $key => $item)
        {
            if ($collectable === $item)
            {
                return $key;
            }
        }

        return -1;
    }

    /**
     * {@inheritdoc}
     */
    public function findAt($id)
    {
        $this->throwExceptionIfIdDoesNotExist($id);
        return $this->collection[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function size(): int
    {
        return count($this->collection);
    }

    /**
     * Returns the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     *
     * @return mixed
     *
     * @throws \RuntimeException When the collection is empty.
     */
    public function current()
    {
        $this->throwExceptionIfCollectionIsEmpty();
        return current($this->collection);
    }

    /**
     * Move forward to the next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     *
     * @throws \RuntimeException When the collection is empty
     */
    public function next(): void
    {
        $this->throwExceptionIfCollectionIsEmpty();
        next($this->collection);
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     *
     * @return int
     *
     * @throws \RuntimeException When the collection is empty.
     */
    public function key(): int
    {
        $this->throwExceptionIfCollectionIsEmpty();
        return key($this->collection);
    }

    /**
     * Checks if the current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     *
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->collection) !== null;
    }

    /**
     * Rewind the collection's position to the first index.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind(): void
    {
        reset($this->collection);
    }

    private function throwExceptionIfCollectionIsEmpty()
    {
        if ($this->size() == 0)
        {
            throw new OutOfBoundsException("Unable to access items in an empty collection.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): CollectionInterface
    {
        $this->collection = [];
        return $this;
    }

    /**
     * Checks if an index exists in the collection.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param int The index to check.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException When `$offset` is not an integer.
     * @throws \OutOfBoundsException When the `$offset` doesn't exist or if the collection is empty.
     */
    public function offsetExists($offset): bool
    {
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        $this->throwExceptionIfIdDoesNotExist($offset);
        $this->throwExceptionIfCollectionIsEmpty();

        return $this->idExists($offset);
    }

    private function throwExceptionIfOffsetIsNotAnInteger($offset): void
    {
        if (is_int($offset) === false)
        {
            $message = sprintf(
                'Collection offset type must be an integer. %s given.',
                gettype($offset)
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * Retrieves an item at the given offset in the collection.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param int $offset The index to retrieve from.
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException When `$offset` is not an integer.
     * @throws \OutOfBoundsException When the `$offset` doesn't exist or if the collection is empty.
     */
    public function offsetGet($offset)
    {
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        $this->throwExceptionIfIdDoesNotExist($offset);
        $this->throwExceptionIfCollectionIsEmpty();

        return $this->collection[$offset];
    }

    /**
     * Sets a new value in the collection at the given `$offset`.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset The offset location in the collection.
     * @param mixed $value The value to set.
     *
     * @throws \InvalidArgumentException When `$offset` is not an integer.
     * @throws \OutOfBoundsException If the collection is empty.
     */
    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        $this->throwExceptionIfCollectionIsEmpty();

        $this->collection[$offset] = $value;
    }

    /**
     * Unset a value in the collection at the given offset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed The offset to unset.
     */
    public function offsetUnset($offset): void
    {
        $this->offsetSet($offset, null);
    }
}