<?php

namespace App\Misc\Backend;

/**
 * Another class for wrapping PHP Method names into more recognisable class methods.
 */
class StringFunctionWrapper {

    public static function split(string $toSplitIn, string $toSplitAt) : array {
        return explode($toSplitAt, $toSplitIn);
    }

    public static function replace(string $toReplaceIn, string $toSearchFor, string $toReplaceWith) : string {
        return str_replace($toSearchFor, $toReplaceWith, $toReplaceIn);
    }

    public static function getClassName(object $obj) : string {
        return get_class($obj);
    }
}