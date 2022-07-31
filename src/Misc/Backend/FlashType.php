<?php

namespace App\Misc\Backend;

/**
 * Pseudo Java-like Enum where the objects of this class can have properties and values link to them.
 */
class FlashType {

    //The instance variables
    private static FlashType $success;
    private static FlashType $error;

    //The properties of the instance variables
    public string $typeName;

    public function __construct(string $name) {
        $this->typeName = $name;
    }

    //Returning either the success or the error instance variable

    public static function getSuccessType() : FlashType {
        if (!isset(FlashType::$success) || FlashType::$success == null)
            FlashType::$success = new FlashType("success");
        return FlashType::$success;
    }

    public static function getErrorType() : FlashType {
        if (!isset(FlashType::$error) || FlashType::$error == null)
            FlashType::$error = new FlashType("error");
        return FlashType::$error;
    }

}