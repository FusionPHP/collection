<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\AbstractCollection;
use Fusion\Collection\Contracts\CollectionInterface;
use Fusion\Collection\Exceptions\CollectionException;

/**
 * An implementation of a collection.
 *
 * A collection holds values internally with a numeric index. The values can consist of any value
 * that can be stored in a PHP array that isn't `null`. The internal index grows and shrink with
 * the collection as items are removed or added.
 *
 * Collections are traversable and can be looped or accessed directly using array index notation.
 *
 * @since 1.0.0
 */
class Collection extends AbstractCollection implements CollectionInterface
{
    /**
     * Instantiates a collection object with an optional array of starter items.
     *
     * If the starting items contain any `null` values, an exception will be thrown.
     *
     * @param array $items
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item)
        {
            $this->add($item);
        }
    }

    /** {@inheritdoc} */
    public function add($value): CollectionInterface
    {
        $this->throwExceptionIfValueIsNull($value);
        array_push($this->collection, $value);
        return $this;
    }

    /** {@inheritdoc} */
    public function replace(int $key, $value): CollectionInterface
    {
        $this->offsetSet($key, $value);
        return $this;
    }

    private function throwExceptionIfIdDoesNotExist(int $id): void
    {
        parent::throwExceptionIfOffsetDoesNotExist($id);
    }

    /** {@inheritdoc} */
    public function find(int $key)
    {
        $this->throwExceptionIfIdDoesNotExist($key);
        return $this->offsetGet($key);
    }

    private function throwExceptionIfOffsetIsNotAnInteger($offset): void
    {
        if (is_int($offset) === false)
        {
            $message = sprintf(
                'Collection offset type must be an integer. %s given.',
                gettype($offset)
            );

            throw new CollectionException($message);
        }
    }

    /**
     * Retrieves a value at the given offset.
     *
     * This method will throw a `CollectionException` if the offset is not an integer or if the
     * offset does not exist.
     *
     * @see \Fusion\Collection\Contracts\AbstractCollection::offsetGet()
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset
     *
     * @return mixed
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
     */
    public function offsetGet($offset)
    {
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        parent::throwExceptionIfOffsetDoesNotExist($offset);
        return parent::offsetGet($offset);
    }

    /**
     * Sets a value at the given offset.
     *
     * This method will throw a `CollectionException` if the offset does not exist or if the offset
     * is not an integer.
     *
     * @see \Fusion\Collection\Contracts\AbstractCollection::offsetSet()
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
        $this->throwExceptionIfOffsetIsNotAnInteger($offset);
        parent::throwExceptionIfOffsetDoesNotExist($offset);
        parent::offsetSet($offset, $value);
    }
}