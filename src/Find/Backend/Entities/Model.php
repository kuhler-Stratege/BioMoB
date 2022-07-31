<?php

namespace App\Find\Backend\Entities;

use App\LogIn\Backend\Entities\Member;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Misc\DBFacades as FacadeDir;

/**
 * @ORM\Entity(repositoryClass=FacadeDir\ModelDBFacade::class)
 * @ORM\Table("Models")
 *
 * @UniqueEntity(fields="id", message="This model ID is already taken")
 */
class Model {   //TODO: Migrate and test

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=180, unique=true)
     */
    private int $id;

    /**
     * @ORM\ManyToMany(targetEntity="Contributer", inversedBy="relatedModels")
     * @ORM\JoinTable(name="model_editor")
     */
    private ArrayCollection $editors;

    //General information

    /**
     * @ORM\Column(type="string", length=4095)
     */
    private string $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $shortName;

    /**
     * @ORM\Column(type="string", length=4095)
     */
    private string $srcLink;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", mappedBy="relatedModels")
     */
    private ArrayCollection $keywords;

    /**
     * @ORM\Column(type="integer", length=180)
     */
    private Member $mainContributer;

    //Authors

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $members;  //TOOD: Extra Entity mit Vor-, Nachname und Link zum Membereintrag erstellen

    //Descriptions

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $shortDesc;

    /**
     * @ORM\Column(type="string", length=4095)
     */
    private string $longDesc;

    /**
     * @ORM\Column(type="string", length=4095)
     */
    private string $paperLink;

    //Technical Info

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $languages;

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $frameworks;

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $dependencies;

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $otherInfo;

    //Data Info

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $config;

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $inputVars;

    /**
     * @ORM\Column(type="json", length=4095)
     */
    private array $outputVars;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFullName(): string {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getShortName(): string {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     */
    public function setShortName(string $shortName): void {
        $this->shortName = $shortName;
    }

    /**
     * @return string
     */
    public function getSrcLink(): string {
        return $this->srcLink;
    }

    /**
     * @param string $srcLink
     */
    public function setSrcLink(string $srcLink): void {
        $this->srcLink = $srcLink;
    }

    /**
     * @return ArrayCollection
     */
    public function getKeywords(): ArrayCollection {
        return $this->keywords;
    }

    /**
     * @param ArrayCollection $keywords
     */
    public function setKeywords(ArrayCollection $keywords): void {
        $this->keywords = $keywords;
    }

    /**
     * @return Member
     */
    public function getMainContributer(): Member {
        return $this->mainContributer;
    }

    /**
     * @param Member $mainContributer
     */
    public function setMainContributer(Member $mainContributer): void {
        $this->mainContributer = $mainContributer;
    }

    /**
     * @return array
     */
    public function getMembers(): array {
        return $this->members;
    }

    /**
     * @param array $members
     */
    public function setMembers(array $members): void {
        $this->members = $members;
    }

    /**
     * @return string
     */
    public function getShortDesc(): string {
        return $this->shortDesc;
    }

    /**
     * @param string $shortDesc
     */
    public function setShortDesc(string $shortDesc): void {
        $this->shortDesc = $shortDesc;
    }

    /**
     * @return string
     */
    public function getLongDesc(): string {
        return $this->longDesc;
    }

    /**
     * @param string $longDesc
     */
    public function setLongDesc(string $longDesc): void {
        $this->longDesc = $longDesc;
    }

    /**
     * @return string
     */
    public function getPaperLink(): string {
        return $this->paperLink;
    }

    /**
     * @param string $paperLink
     */
    public function setPaperLink(string $paperLink): void {
        $this->paperLink = $paperLink;
    }

    /**
     * @return array
     */
    public function getLanguages(): array {
        return $this->languages;
    }

    /**
     * @param array $languages
     */
    public function setLanguages(array $languages): void {
        $this->languages = $languages;
    }

    /**
     * @return array
     */
    public function getFrameworks(): array {
        return $this->frameworks;
    }

    /**
     * @param array $frameworks
     */
    public function setFrameworks(array $frameworks): void {
        $this->frameworks = $frameworks;
    }

    /**
     * @return array
     */
    public function getDependencies(): array {
        return $this->dependencies;
    }

    /**
     * @param array $dependencies
     */
    public function setDependencies(array $dependencies): void {
        $this->dependencies = $dependencies;
    }

    /**
     * @return array
     */
    public function getOtherInfo(): array {
        return $this->otherInfo;
    }

    /**
     * @param array $otherInfo
     */
    public function setOtherInfo(array $otherInfo): void {
        $this->otherInfo = $otherInfo;
    }

    /**
     * @return array
     */
    public function getConfig(): array {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getInputVars(): array {
        return $this->inputVars;
    }

    /**
     * @param array $inputVars
     */
    public function setInputVars(array $inputVars): void {
        $this->inputVars = $inputVars;
    }

    /**
     * @return array
     */
    public function getOutputVars(): array {
        return $this->outputVars;
    }

    /**
     * @param array $outputVars
     */
    public function setOutputVars(array $outputVars): void {
        $this->outputVars = $outputVars;
    }

    /**
     * Creates and fills a mapper that is used by Doctrine to sort the raw sql output.
     */
    public static function createMapper(EntityManagerInterface $manager) :ResultSetMappingBuilder {
        $fieldMapper = new ResultSetMappingBuilder($manager);
        $fieldMapper->addEntityResult(Model::class, "mo");
        $fieldMapper->addFieldResult("mo", "id", "id");
        $fieldMapper->addFieldResult("mo", "editors", "editors");
        $fieldMapper->addFieldResult("mo", "full_name", "fullName");
        $fieldMapper->addFieldResult("mo", "short_name", "shortName");
        $fieldMapper->addFieldResult("mo", "src_link", "srcLink");
        $fieldMapper->addFieldResult("mo", "keywords", "keywords");
        $fieldMapper->addFieldResult("mo", "owner", "mainContributer");
        $fieldMapper->addFieldResult("mo", "other_members", "members");
        $fieldMapper->addFieldResult("mo", "short_description", "shortDesc");
        $fieldMapper->addFieldResult("mo", "long_description", "longDesc");
        $fieldMapper->addFieldResult("mo", "paper_link", "paperLink");
        $fieldMapper->addFieldResult("mo", "language_names", "languages");
        $fieldMapper->addFieldResult("mo", "framework_names", "frameworks");
        $fieldMapper->addFieldResult("mo", "dependencie_names", "dependencies");
        $fieldMapper->addFieldResult("mo", "other_information", "otherInfo");
        $fieldMapper->addFieldResult("mo", "configuration", "config");
        $fieldMapper->addFieldResult("mo", "input_variables", "inputVars");
        $fieldMapper->addFieldResult("mo", "output_variables", "outputVars");
        return $fieldMapper;
    }

}