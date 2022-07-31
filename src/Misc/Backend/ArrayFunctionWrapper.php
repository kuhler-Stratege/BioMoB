<?php

namespace App\Misc\Backend;

/**
 * Wrapper class for converting PHP Method names into more understandable class methods.
 */
class ArrayFunctionWrapper {

    public static function merge(array $one, array $two) : array {
        return array_merge($one, $two);
    }

    public static function push(array &$toAddTo, string $toAdd) : void {
        $toAddTo[] = $toAdd;
    }

    public static function exists(array $toLookIn, string $toFind) : bool {
        return in_array($toFind, $toLookIn);
    }

    public static function pushIfAbsent(array &$toAddTo, string $key) : void {
        if (!ArrayFunctionWrapper::exists($toAddTo, $key))
            ArrayFunctionWrapper::push($toAddTo, $key);
    }

    public static function getNthElement(array $array, int $n) : object {
        $keys = array_keys($array);
        return $array[$keys[$n]];
    }

    public static function length(array $array) : int {
        return count($array);
    }

}