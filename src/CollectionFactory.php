<?php

/**
 * Part of the Fusion.Collection package.
 *
 * @license MIT
 */

declare(strict_types=1);

namespace Fusion\Collection;

use Fusion\Collection\Contracts\CollectionValidationInterface;

class CollectionFactory
{
    private static $cachedValidator;

    private static function getValidator(): CollectionValidationInterface
    {
        if (self::$cachedValidator === null || (self::$cachedValidator instanceof CollectionValidationInterface) === false)
        {
            self::$cachedValidator = new CollectionValidator();
        }

        return self::$cachedValidator;
    }

    public static function newCollection(array $starterItems = []): Collection
    {
        return new Collection(self::getValidator(), $starterItems);
    }

    public static function newTypedCollection(string $acceptedType, array $starterItems = []): TypedCollection
    {
        return new TypedCollection(self::getValidator(), $acceptedType, $starterItems);
    }

    public static function newDictionary(array $starterItems = []): Dictionary
    {
        return new Dictionary(self::getValidator(), $starterItems);
    }

    public static function newTypedDictionary(string $acceptedType, array $starterItems = []): TypedDictionary
    {
        return new TypedDictionary(self::getValidator(), $acceptedType, $starterItems);
    }
}