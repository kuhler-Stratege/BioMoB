<?php

namespace App\LogIn\Backend\Entities;

use App\Misc\Backend\ArrayFunctionWrapper;

/**
 * Admin User Entity
 */
class Admin extends Contributer {

    /**
     * Checks if the current user has Admin Privileges
     */
    public function checkRolesArray(array &$roles): void {
        parent::checkRolesArray($roles);
        ArrayFunctionWrapper::pushIfAbsent($roles, "ROLE_Admin");
    }

    /**
     * Pseudocast that helps PHPStorm with code completion.
     * Has no functionality other than that.
     */
    public static function castToAdmin($user) : Admin {
        return $user;
    }

}
