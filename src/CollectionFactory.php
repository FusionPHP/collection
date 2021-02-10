<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionValidationInterface;

/**
 * Factory class to ease instantiation of collection and dictionary objects.
 *
 * @since 2.0.0
 */
class CollectionFactory
{
    private static $cachedValidator;

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
     * @return \Fusion\Collection\Collection
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
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
     * @return \Fusion\Collection\TypedCollection
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
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
     * @return \Fusion\Collection\Dictionary
     *
     * @throws \Fusion\Collection\Exceptions\CollectionException
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
     * @return \Fusion\Collection\TypedDictionary
     * @throws \Fusion\Collection\Exceptions\CollectionException
     * @see \Fusion\Collection\TypedDictionary::__construct()
     *
     */
    public static function newTypedDictionary(string $acceptedType, array $starterItems = []): TypedDictionary
    {
        return new TypedDictionary(self::getValidator(), $acceptedType, $starterItems);
    }
}