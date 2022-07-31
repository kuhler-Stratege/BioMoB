<?php

namespace App\Misc\DBFacades;

use App\Find\Backend\Entities\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Facade Singleton Class for downloading, adding and updating model data.
 * This class is probably the most important because the whole unique selling point bases on the functionality of this class
 *
 * @extends ServiceEntityRepository<Model>
 *
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelDBFacade extends ServiceEntityRepository {  //TODO: Test and Debug

    /**
     * Singleton Variable
     */
    public static ModelDBFacade $instance;

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Model::class);
        if (!isset(ModelDBFacade::$instance))
            ModelDBFacade::$instance = $this;
    }

    public function sendChangesToDatabase(Model $alteredModel) :void {
        $this->_em->persist($alteredModel);
        $this->_em->flush();
    }

    /**
     * Removes a model from the database
     */
    public function removeModel(Model $toDelete) :void {
        $this->_em->remove($toDelete);
        $this->_em->flush();
    }

    /**
     * Gets the next X models, where X is the amount between "start" and "end" Variable.
     */
    public function getNextModels(int $start, int $end) : array {
        //TODO: Implement offset and loading of only X models correctly
        $statement = $this->_em->createNativeQuery("SELECT * FROM models AS model WHERE model.id BETWEEN ? AND ?",
            Model::createMapper($this->_em));
        $statement->setParameter(0, $start);
        $statement->setParameter(1, $end);
        return $statement->getResult();
    }

    public function filterByName(string $toFind, int $maxLength, int $start) :array {
        $statement = $this->_em->createNativeQuery(
        //TODO: Implement offset and loading of only X models correctly
            "SELECT * FROM models AS model WHERE model.full_name = ? OR model.short_name = ? OR model.full_name LIKE ? OR model.short_name LIKE ? LIMIT ?",
            Model::createMapper($this->_em));
        for($i = 0; $i < 4; $i++)
            $statement->setParameter($i, $toFind);
        $statement->setParameter(4, $maxLength);
        return $statement->getResult();
    }

    public function filterByKeywords(string $keyname, int $maxLength, int $start) :array {
        $statement = $this->_em->createNativeQuery(
            "SELECT * FROM modelkeywords AS pivot 
                JOIN models AS model ON model.id = pivot.modelID 
                JOIN keywords AS keyy ON keyy.id = pivot.keywordID 
                WHERE keyy.name = ? LIMIT ?",
            //TODO: Implement offset and loading of only X models correctly
            Model::createMapper($this->_em));
        $statement->setParameter(0, $keyname);
        $statement->setParameter(1, $maxLength);
        return $statement->getResult();
    }

    /**
     * Asks Doctrine to download each and every model from the database and returns the downloaded models inside an array.
     * Uses a native Query which is a raw SQL Statement combined with a ResultSetBuilder got from the Model Entity Class.
     */
    public function getAllModels() :array {
        $statement = $this->_em->createNativeQuery("SELECT * FROM modelkeywords AS pivot 
                JOIN models AS model ON model.id = pivot.modelID 
                JOIN keywords AS keyy ON keyy.id = pivot.keywordID",
            Model::createMapper($this->_em));
        return $statement->getResult();
    }

}