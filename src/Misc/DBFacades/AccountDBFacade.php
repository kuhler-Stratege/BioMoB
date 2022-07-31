<?php

namespace App\Misc\DBFacades;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Backend\ArrayFunctionWrapper;
use App\Misc\Backend\StringFunctionWrapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Facade Singleton Class for interacting with Doctrine and the database for getting and updating user information.
 * Contains all SQL Statements associated User Management.
 * Uses the ResultSetBuilder in the Member class and its children.
 *
 * @extends ServiceEntityRepository<Member>
 *
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountDBFacade extends ServiceEntityRepository implements PasswordUpgraderInterface {

    /**
     * Singleton Variable
     */
    public static AccountDBFacade $instance;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Member::class);
        AccountDBFacade::$instance = $this;
    }

    public function sendChangesToDatabase(Member $entity, bool $flush = false): void {
        $this->_em->persist($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Removes a user from the database
     */
    public function deleteUser(Member $entity, bool $flush = false): void {
        $this->_em->remove($entity);

        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Called during log in to look for a user in the database that matches the Mail Address given through the "signInRequest" Variable.
     * Returns the found and downloaded user object or null if no such user exists.
     */
    public function getMemberSigningIn(Request $signInRequest) : ?Member {
        $mail = $signInRequest->request->get("Email_");
        if ($mail == null) {
            $mail = $signInRequest->request->get("Email");
            if ($mail == null)
                return null;
        }
        $signInRequest->getSession()->set(Security::LAST_USERNAME, $mail);
        return $this->loadUser('eMail', [$mail]);
    }

    /**
     * Asks Doctrine to download the user data by the "property" "value" variable pair.
     * Uses a native query which is a combination of a pure SQL Statement and
     * a call to (in this case) the Member ResultSetBuilder
     */
    public function loadUser(string $property, array $value) : ?Member {
        $command = $this->_em->createNativeQuery('SELECT m.uuid, m.roles, m.password, m.username, m.is_verified, m.eMail FROM accounts AS m WHERE ' . $property . ' = ?',
            Member::createMapper($this->_em));
        $command->setParameter(0, $value[0]);
        $userArray = $command->getResult();
        if (ArrayFunctionWrapper::length($userArray) == 0)
            return null;
        return Member::castToMember(ArrayFunctionWrapper::getNthElement($userArray, 0));
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void {
        if (!$user instanceof Member) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', StringFunctionWrapper::getClassName($user)));
        }
        $user->setPassword($newHashedPassword);
        $this->sendChangesToDatabase($user, true);
    }

    public function getEntityManager() : EntityManagerInterface {
        return $this->_em;
    }
}
