<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionValidationInterface;
use Fusion\Collection\Exceptions\CollectionException;

/**
 * Factory class to ease instantiation of collection and dictionary objects.
 *
 * @since 2.0.0
 */
class CollectionFactory
{
    private static CollectionValidationInterface $cachedValidator;

    private static function getValidator(): CollectionValidationInterface
    {
        if (self::$cachedValidator === null || (self::$cachedValidator instanceof CollectionValidationInterface) === false) {
            self::$cachedValidator = new CollectionValidator();
        }

        return self::$cachedValidator;
    }

    /**
     * Creates a new `Collection` with an optional set of starter items.
     *
     * @param array $starterItems
     *
     * @return Collection
     *
     * @throws CollectionException
     * @see \Fusion\Collection\Collection::__construct()
     *
     */
    public static function newCollection(array $starterItems = []): Collection
    {
        return new Collection(self::getValidator(), $starterItems);
    }

    /**
     * Creates a new `TypedCollection` with an optional set of starter items.
     *
     * @param string $acceptedType
     * @param array $starterItems
     *
     * @return TypedCollection
     *
     * @throws CollectionException
     * @see \Fusion\Collection\TypedCollection::__construct()
     *
     */
    public static function newTypedCollection(string $acceptedType, array $starterItems = []): TypedCollection
    {
        return new TypedCollection(self::getValidator(), $acceptedType, $starterItems);
    }

    /**
     * Creates a new `Dictionary` with an optional set of starter items.
     *
     * @param array $starterItems
     *
     * @return Dictionary
     *
     * @throws CollectionException
     * @see \Fusion\Collection\Dictionary::__construct()
     *
     */
    public static function newDictionary(array $starterItems = []): Dictionary
    {
        return new Dictionary(self::getValidator(), $starterItems);
    }

    /**
     * Creates a new `TypedDictionary` with an optional set of starter items.
     *
     * @param string $acceptedType
     * @param array $starterItems
     *
     * @return TypedDictionary
     * @throws CollectionException
     * @see \Fusion\Collection\TypedDictionary::__construct()
     *
     */
    public static function newTypedDictionary(string $acceptedType, array $starterItems = []): TypedDictionary
    {
        return new TypedDictionary(self::getValidator(), $acceptedType, $starterItems);
    }
}