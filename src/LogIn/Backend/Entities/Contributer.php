<?php

namespace App\LogIn\Backend\Entities;


use App\Misc\Backend\ArrayFunctionWrapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Contributer User Entity.
 * A contributer is everyone that at least is member at one project or submitted at least one model
 */
class Contributer extends Member {

    /**
     * Link to the models the user has contributed
     * 
     * @ORM\ManyToMany(targetEntity="Model", mappedBy="editors")
     */
    protected ArrayCollection $relatedModels;

    /**
     * Checks if the roles contain user, member and contributer
     */
    protected function checkRolesArray(array &$roles): void {
        parent::checkRolesArray($roles);
        ArrayFunctionWrapper::pushIfAbsent($roles, "ROLE_Contributer");
    }

    /**
     * Pseudocast that helps PHPStorm with code completion.
     * Has no functionality other than that.
     */
    public static function castToContributer($user) : Contributer {
        return $user;
    }

    /**
     * Creates a mapper used by doctrine to sort raw sql output
     */
    public static function createMapper(EntityManagerInterface $manager): ResultSetMappingBuilder{
        $fieldMapper = new ResultSetMappingBuilder($manager);
        $fieldMapper->addEntityResult(Contributer::class, "me");
        Contributer::fillMapper($fieldMapper);
        return $fieldMapper;
    }

    /**
     * Fills the Mapper used by Doctrine
     */
    public static function fillMapper(ResultSetMappingBuilder $mapper): void {
        parent::fillMapper($mapper);
        $mapper->addFieldResult("me", "editors", "editors");
    }

}
