<?php
/**
 * Created by PhpStorm.
 * User: Jason Walker
 * Date: 5/21/2018
 * Time: 9:05 PM
 */

namespace Fusion\Collection\Contracts;


interface CollectionValidationInterface
{
    public function validateNonNullValue($value): void;
    public function validateOffsetExists($offset, AbstractCollection $collection): void;
    public function validateIntValue($value): void;
    public function validateStringValue($value): void;
    public function validateNonEmptyAcceptedType(string $acceptedType): void;
    public function validateValueIsAcceptedType($value, string $acceptedType): void;
}