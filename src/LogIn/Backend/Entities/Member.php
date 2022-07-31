<?php

namespace App\LogIn\Backend\Entities;

use App\Misc\Backend\ArrayFunctionWrapper;
use App\Misc\DBFacades\AccountDBFacade;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The class that every logged-in user has.
 * This class adds a role "ROLE_Member" which basically replaces "ROLE_USER"
 *
 * @ORM\Entity(repositoryClass=AccountDBFacade::class)
 * @ORM\Table("Accounts")
 *
 * @UniqueEntity(fields="uuid", message="This UUID is already taken")
 */
class Member implements UserInterface, PasswordAuthenticatedUserInterface{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=180, unique=true)
     */
    protected int $uuid;

    /**
     * @ORM\Column(type="string", name="eMail", unique=true)
     */
    protected string $mail;

    /**
     * @ORM\Column(type="json")
     */
    protected array $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    protected string $password;

    /**
     * @ORM\Column(type="string", name="username")
     */
    protected string $name;

    /**
     * @ORM\Column(type="boolean", name="is_verified")
     */
    private bool $isVerified;

    /**
     * Creates and sets up a new User during registration
     *
     * @param string $username
     * @param string $eMail
     */
    public function __construct(string $username, string $eMail) {
        $this->setRoles(["ROLE_Member"]);
        $this->name = $username;
        $this->mail = $eMail;
        $this->isVerified = false;
    }

    public function getUuid(): int {
        return $this->uuid;
    }

    public function getUsername() : string {
        return $this->name;
    }

    public function setUsername(string $newUsername) : void {
        $this->name = $newUsername;
    }

    public function getEMail() : string {
        return $this->mail;
    }

    public function setEMail(string $newMail) : void {
        $this->mail = $newMail;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): int {
        return $this->uuid;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array{
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): void {
        $this->checkRolesArray($roles);
        $this->roles = $roles;
    }

    /**
     * Checks if the user has both "ROLE_USER" and "ROLE_Member".
     * The first one is not used by the project, but maybe by symfony
     * If the first Role is not used by Symfony it can be deleted
     * The second one is used by the project
     */
    protected function checkRolesArray(array &$roles) : void {
        ArrayFunctionWrapper::pushIfAbsent($roles, "ROLE_USER");
        ArrayFunctionWrapper::pushIfAbsent($roles, "ROLE_Member");
    }

    /**
     * Checks if the user is correctly loaded and if not, reloads the current user
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        if (!isset($this->password))
            $this->password = AccountDBFacade::$instance->loadUser('uuid', [$this->uuid])->password;
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Not used by this project but required by the interface
     *
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string {
        return null;
    }

    /**
     * Not used by this project
     *
     * @see UserInterface
     */
    public function eraseCredentials() : void {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool {
        return $this->isVerified;
    }

    public function verifyMember() : void {
        $this->isVerified = true;
    }

    /**
     * Pseudocast for PHPStorm for code completion
     * Beside that, it has no use case.
     */
    public static function castToMember($user) : Member {
        return $user;
    }

    /**
     * Creates a mapper that is used by Doctrine to sort the raw SQL output
     */
    public static function createMapper(EntityManagerInterface $manager) : ResultSetMappingBuilder {
        $fieldMapper = new ResultSetMappingBuilder($manager);
        $fieldMapper->addEntityResult(Member::class, "me");
        Member::fillMapper($fieldMapper);
        return $fieldMapper;
    }

    /**
     * Fills the mapper for Doctrine
     */
    public static function fillMapper(ResultSetMappingBuilder $mapper) :void {
        $mapper->addFieldResult("me", "password", "password");
        $mapper->addFieldResult("me", "username", "name");
        $mapper->addFieldResult("me", "eMail", "mail");
        $mapper->addFieldResult("me", "uuid", "uuid");
        $mapper->addFieldResult("me", "roles", "roles");
        $mapper->addFieldResult("me", "is_verified", "isVerified");
    }

}
