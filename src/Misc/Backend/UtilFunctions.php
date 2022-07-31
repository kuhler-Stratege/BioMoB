<?php

namespace App\Misc\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Several variables and method that I used in different places in the project and thus are placed here.
 */
class UtilFunctions {

    public static string $breadcrumbsRestricted = "A place where you are not allowed to be ;)";

    //The root folder paths for both css and image files
    public static string $cssRoot = "/assets/css/";
    public static string $imageRoot = "/assets/images/";

    public static function isAdmin(UserInterface $user) : bool {
        return ArrayFunctionWrapper::exists($user->getRoles(), "ROLE_Admin");
    }

    public static function isContributer(UserInterface $user) : bool {
        return ArrayFunctionWrapper::exists($user->getRoles(), "ROLE_Contributer");
    }

    public static function functionToCallable(object $classObj, string $methodName) : callable {
        return [$classObj, $methodName];
    }

    public static function getClassName(object $class) : string {
        return get_class($class);
    }

    /**
     * Because the other method of adding a flash via the controller does not work,
     * I used this way of adding a flash message
     */
    public static function addFlash(Request $request, FlashType $type, string $message) : void {
        $request->getSession()->getFlashBag()->add($type->typeName, $message);
    }

}
