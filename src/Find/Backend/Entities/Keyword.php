<?php

namespace App\Find\Backend\Entities;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Misc\DBFacades as FacadeDir;

/**
 * @ORM\Entity(repositoryClass=FacadeDir\KeywordDBFacade::class)
 * @ORM\Table("Keywords")
 *
 * @UniqueEntity(fields="id", message="This keyword already exists")
 */
class Keyword {  //TODO: Migrate and test

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=180, unique=true)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * Array Collections seemed to be used by Doctrine for Joins so this is the datatype for all joined fields
     *
     * @ORM\ManyToMany(targetEntity="Model", mappedBy="keywords")
     * @ORM\JoinTable(name="modelkeywords")
     */
    private ArrayCollection $relatedModels;

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $newName) :void {
        $this->name = $newName;
    }

    public function getRelatedModels(): ArrayCollection {
        return $this->relatedModels;
    }

    public static function createMapper(EntityManagerInterface $manager) :ResultSetMappingBuilder {
        $fieldMapper = new ResultSetMappingBuilder($manager);
        $fieldMapper->addEntityResult(Keyword::class, "key");
        $fieldMapper->addFieldResult("key", "id", "id");
        $fieldMapper->addFieldResult("key", "name", "name");
        $fieldMapper->addFieldResult("key", "models", "relatedModels");
        return $fieldMapper;
    }

}