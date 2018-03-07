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
     * An array of restrictions.
     *
     * @var array
     */
    protected $restrictions = [];

    /**
     * Specifies if strict mode is on.
     *
     * When strict mode is on exceptions are thrown when the collection restrictions are violated.
     * When strict mode is off the class will silently fail at certain operations.
     *
     * @var bool
     */
    protected $strictMode = false;

    /**
     * Constructor.
     *
     * Creates a collection with an optional set of initial starter items and restrictions.
     *
     * @param array $items
     * @param array $restrictions
     */
    public function __construct(array $items = [], array $restrictions = [])
    {
        foreach ($restrictions as $restriction)
        {
            $this->addRestriction($restriction);
        }
        foreach ($items as $item)
        {
            $this->add($item);
        }
    }

    /**
     * Adds an object to a collection.
     *
     * Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
     */
    public function add($collectable): CollectionInterface
    {
        array_push($this->collection, $collectable);
        return $this;
    }

    /**
     * Searches the collection for a particular object and removes it.
     *
     *  Will throw an InvalidArgumentException if strict mode is on and restrictions are violated.
     *
     * @param mixed $collectable
     * @throws \InvalidArgumentException
     * @return self
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
     * Removes an object at the specified index.
     *
     * Checks for an item at the specified index and removes it if it exists.  Throws an
     * OutOfBoundsException if strict mode is on and the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return self
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

    /**
     * Checks if a particular object exists.
     *
     * Iterates over the collections looking for an identical of the item provided.  Returns the
     * index of the item or false if it cannot be found.
     *
     * @param mixed $collectable
     * @return int|bool
     */
    public function has($collectable): bool
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
     * Indicates if a collection has more items in it.
     *
     * @return bool
     */
    public function hasMore(): bool
    {
        return ($this->size() > 0);
    }

    /**
     * Gets an item in the collection at the specified index.
     *
     * Looks in the collection at the specified index, if it exists, and returns the item.  If
     * no item is present or the index does not exist null is returned.  Throws an
     * OutOfBoundsException if strict mode is on and the index doesn't exist.
     *
     * @param int $id
     * @throws \OutOfBoundsException
     * @return mixed|null
     */
    public function findAt($id)
    {
        $this->throwExceptionIfIdDoesNotExist($id);
        return $this->collection[$id];
    }

    private function idExists(int $id): bool
    {
        return array_key_exists($id, $this->collection);
    }

    /**
     * Gets the last array key in the collection.
     *
     * @return int
     */
    public function lastId()
    {
        $keys = array_keys($this->collection);
        return array_pop($keys);
    }

    /**
     * Adds a restriction to the collection.
     *
     * Will inform the collection that it will now restrict itself to the type defined.  This
     * method may be invoked multiple times to allow multiple value types to be added to the
     * collection. Restrictions can define scalar and non-scalar PHP types.  When defining specific
     * class types the fully qualified name must be used. E.g.: "\Foo\Bar\Baz"
     *
     * @param string $restriction
     * @return self
     */
    public function addRestriction($restriction)
    {
        $this->restrictions[] = $restriction;
        return $this;
    }

    /**
     * Gets a count of the items in a collection.
     *
     * @return int
     */
    public function size(): int
    {
        return count($this->collection);
    }
}