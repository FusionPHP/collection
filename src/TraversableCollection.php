<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Collection;

use Fusion\Collection\Contracts\TraversableCollectionInterface;

/**
 * Extension of the Collection class to allow the collection to become traversable.
 */
class TraversableCollection extends Collection implements TraversableCollectionInterface
{
    /**
     * Position in the collection.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Rewinds the collection, sets the position at 0.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Returns the value at the current position.
     *
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     * Tells the current position.
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Advances the position by 1.
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * States if the current position has a valid value.
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->collection[$this->position]);
    }
}