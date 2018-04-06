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
use Fusion\Collection\Exceptions\CollectionException;

/**
 * A type-specific collection class.
 *
 * This collection class requires a fully qualified class or interface name is given upon
 * initialization. Operations to add an item to the collection will verify that the item being added
 * is of the allowed type or will trigger an exception to be thrown.
 */
class TypedCollection extends Collection
{
    private $acceptedType;

    /**
     * Constructor.
     *
     * Creates a collection that will enforce items added be an instance of the `$acceptedType`.
     * Optionally, an array of starter items of the `$acceptedType` can also be provided.
     *
     * @param string $acceptedType The fully qualified name of instances the collection will accept.
     * @param array $items A set of items to populate the collection with.
     */
    public function __construct(string $acceptedType, array $items = [])
    {
        if ($acceptedType == '')
        {
            throw new CollectionException('Accepted type string cannot be empty.');
        }

        $this->acceptedType = $acceptedType;
        parent::__construct($items);
    }

    /**
     * {@inheritdoc}
     */
    public function add($item): CollectionInterface
    {
        $this->throwExceptionIfNotAcceptedType($item);
        parent::add($item);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->throwExceptionIfNotAcceptedType($value);
        parent::offsetSet($offset, $value);
    }

    private function throwExceptionIfNotAcceptedType($object): void
    {
        if ($this->notAcceptedType($object))
        {
            $message = sprintf(
                'Unable to modify collection. Only instances of type "%s" are allowed. Type "%s" given.',
                $this->acceptedType,
                is_object($object) ? get_class($object) : gettype($object)
            );

            throw new CollectionException($message);
        }
    }

    private function notAcceptedType($value)
    {
        return ($value instanceof $this->acceptedType) === false || is_null($value);
    }
}