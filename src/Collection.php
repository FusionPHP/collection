<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionInterface;

/**
 * The basic collection class.
 */
class Collection implements CollectionInterface
{

    /**
     * An array holding all collection items.
     *
     * @var array
     */
    protected $collection = [];

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

        if ($position !== false)
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

    private function throwExceptionIfIdDoesNotExist(int $id)
    {
        if ($this->idExists($id) === false)
        {
            throw new \OutOfBoundsException("The id '$id' doesn't exist in the collection.");
        }
    }

    private function idExists(int $id): bool
    {
        return array_key_exists($id, $this->collection);
    }

    private function has($collectable): bool
    {
        foreach ($this->collection as $key => $item)
        {
            if ($collectable === $item)
            {
                return $key;
            }
        }

        return false;
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
}