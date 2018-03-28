<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\AbstractCollection;
use Fusion\Collection\Contracts\CollectionInterface;
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
class Collection extends AbstractCollection implements CollectionInterface
{
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
        $this->throwExceptionIfValueIsNull($collectable);
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
     * {@inheritdoc}
     */
    public function clear(): CollectionInterface
    {
        $this->collection = [];
        return $this;
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
        $this->checkIfOffsetIsAnIntegerAndExists($offset);
        return parent::offsetGet($offset);
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
        $this->checkIfOffsetIsAnIntegerAndExists($offset);
        parent::offsetSet($offset, $value);
    }

    private function checkIfOffsetIsAnIntegerAndExists($offset): void
    {
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        $this->throwExceptionIfOffsetDoesNotExist($offset);
    }

    private function throwExceptionIfOffsetDoesNotExist(int $offset)
    {
        if ($this->idExists($offset) == false)
        {
            throw new OutOfBoundsException("Offset does not exist in the collection.");
        }
    }
}