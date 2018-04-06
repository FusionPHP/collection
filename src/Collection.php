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
use Fusion\Collection\Exceptions\CollectionException;

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
    public function add($value): CollectionInterface
    {
        $this->throwExceptionIfValueIsNull($value);
        array_push($this->collection, $value);
        return $this;
    }

    public function replace(int $key, $value): CollectionInterface
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    private function throwExceptionIfIdDoesNotExist(int $id): void
    {
        parent::throwExceptionIfOffsetDoesNotExist($id);
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $key)
    {
        $this->throwExceptionIfIdDoesNotExist($key);
        return $this->offsetGet($key);
    }

    private function throwExceptionIfOffsetIsNotAnInteger($offset): void
    {
        if (is_int($offset) == false)
        {
            $message = sprintf(
                'Collection offset type must be an integer. %s given.',
                gettype($offset)
            );

            throw new CollectionException($message);
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
}