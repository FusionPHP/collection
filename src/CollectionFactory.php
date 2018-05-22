<?php
/**
 * Created by PhpStorm.
 * User: jwalker
 * Date: 5/22/2018
 * Time: 9:27 AM
 */

namespace Fusion\Collection;


use Fusion\Collection\Contracts\CollectionValidationInterface;

class CollectionFactory
{
    /** @var \Fusion\Collection\Contracts\CollectionValidationInterface */
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
        return new Collection($starterItems, self::getValidator());
    }

    public static function newTypedCollection(string $acceptedType, array $starterItems = []): TypedCollection
    {
        return new TypedCollection($acceptedType, $starterItems, self::getValidator());
    }
}