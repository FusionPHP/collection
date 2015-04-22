<?php
/**
 * Part of the Fusion.Collection utility package.
 *
 * @author Jason L. Walker
 * @license MIT
 */

namespace Fusion\Utilities\Collection\Library;


/**
 * Basic class with predefined constants to add known restrictions to a collection.
 *
 */
class Restriction
{

    //Scalar Types
    const BOOL = "bool";
    const INT = "int";
    const FLOAT = "float";
    const STRING = "string";

    //Non-scalar Types
    const ARR = "array";
    const OBJECT = "object";
    const RESOURCE = "resource";
    const CALLBACK = "callback";

}