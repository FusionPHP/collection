<?php

/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionInterface;
use Iterator;
use OutOfBoundsException;

/**
 * The basic collection class.
 */
class Collection implements CollectionInterface, Iterator
{
    /**
     * An array holding all collection items.
     *
     * @var array
     */
    protected $collection = [];

    /**
     * An integer holding he current element index for iterating purposes.
     *
     * @var int
     */
    private $currentIndex;

    /**
     * Constructor.
     *
     * Creates a collection with an optional set of initial starter items.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item)
        {
            $this->add($item);
        }

        $this->currentIndex = 0;
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
    public function remove($collectable): CollectionInterface
    {
        $position = $this->has($collectable);

        if ($position >= 0)
        {
            $this->removeAt($position);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeAt(int $id): CollectionInterface
    {
        $this->throwExceptionIfIdDoesNotExist($id);
        array_splice($this->collection, $id, 1);

        return $this;
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
     * @return mixed
     */
    public function current()
    {
        $this->throwExceptionIfCollectionIsEmpty();
        return $this->collection[$this->currentIndex];
    }

    /**
     * Move forward to the next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     */
    public function next(): void
    {
        $this->throwExceptionIfCollectionIsEmpty();
        $this->currentIndex++;
    }

    /**
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return int
     */
    public function key(): int
    {
        $this->throwExceptionIfCollectionIsEmpty();
        return $this->currentIndex;
    }

    /**
     * Checks if the current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return bool
     */
    public function valid(): bool
    {
        return $this->idExists($this->currentIndex);
    }

    /**
     * Rewind the collection's position to the first element.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
    }

    private function throwExceptionIfCollectionIsEmpty()
    {
        if ($this->size() == 0)
        {
            throw new OutOfBoundsException("Unable to traverse or access items in an clear collection.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): CollectionInterface
    {
        $this->collection = [];
        $this->currentIndex = 0;

        return $this;
    }
}