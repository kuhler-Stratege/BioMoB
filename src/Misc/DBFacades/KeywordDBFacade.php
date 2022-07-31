<?php

namespace App\Misc\DBFacades;

use App\Find\Backend\Entities\Keyword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Facade Singleton Class for accessing the keywords for the models.
 * The keywords need to be in a separate Table because no duplications of keywords are allowed.
 * Also avoids going through the whole models table to look for other keywords.
 *
 * @extends ServiceEntityRepository<Keyword>
 *
 * @method Keyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method Keyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method Keyword[]    findAll()
 * @method Keyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeywordDBFacade extends ServiceEntityRepository {  //TODO: Test and debug

    /**
     * Singleton Variable
     */
    public static KeywordDBFacade $instance;

    public function __construct(ManagerRegistry $manager) {
        parent::__construct($manager, Keyword::class);

        if (!isset(KeywordDBFacade::$instance))
            KeywordDBFacade::$instance = $this;
    }

    public function sendChangesToDatabase(Keyword $alteredModel) :void {
        $this->_em->persist($alteredModel);
        $this->_em->flush();
    }

    /**
     * Removes a keyword from the database
     */
    public function removeKeyword(Keyword $toDelete) :void {
        $this->_em->remove($toDelete);
        $this->_em->flush();
    }

    /**
     * Downloads all keywords and puts them in an array to put them in Twig render calls as value for parameters
     */
    public function getAllKeywords() :array {
        $statement = $this->_em->createNativeQuery(
            "SELECT keyy.id, keyy.name, keyy.models FROM keywords AS keyy",
            Keyword::createMapper($this->_em)
        );
        return $statement->getResult();
    }
}