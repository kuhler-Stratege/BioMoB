<?php

namespace App\LogIn\Backend;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Backend\UtilFunctions;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Called at the start of every page to load the user in the session cache for the current page.
 * The session cache gets deleted when a pages gets unloaded, so this class has to be called on every page
 * to check if a user should be loaded.
 */
class ProfileRefresher implements UserProviderInterface, PasswordUpgraderInterface {

    /**
     * Load a User object from the database or throws a UserNotFoundException.
     * The $uuid argument is whatever value is being returned by the
     * getUserIdentifier() method in the Member class.
     *
     * @throws UserNotFoundException if the user could not be found
     */
    public function loadUserByIdentifier(int $uuid): Member {
        $maybeMember = AccountDBFacade::$instance->loadUser('uuid', [$uuid]);
        if ($maybeMember == null)
            throw new UserNotFoundException("Database Problem detected.");
        return $maybeMember;
    }

    /**
     * Refreshes the user after being reloaded from the session.
     * Return a User object after making sure its data is "fresh".
     * Or throw a UserNotFoundException if the user no longer exists.
     */
    public function refreshUser(UserInterface $user): Member {
        if (!$user instanceof Member && !is_subclass_of($user, "Member")) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', UtilFunctions::getClassName($user)));
        }
        return $this->loadUserByIdentifier($user->getUuid());
    }

    /**
     * Tells Symfony to use this provider for signing in.
     */
    public function supportsClass(string $class): bool {
        return Member::class === $class || is_subclass_of($class, Member::class);
    }

    /**
     * 1. persist the new password in the user storage
     * 2. update the $user object with $user->setPassword($newHashedPassword);
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void {
        AccountDBFacade::$instance->upgradePassword($user, $newHashedPassword);
    }

    public function loadUserByUsername(string $username) : Member {
        $maybeMember = AccountDBFacade::$instance->loadUser('username', [$username]);
        if ($maybeMember == null)
            throw new UserNotFoundException("Database Problem detected");
        return $maybeMember;
    }
}