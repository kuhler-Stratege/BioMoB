<?php

namespace App\Admin\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteModel extends BaseController {

    /**
     * Loads all models and all keywords from the two databases
     * @Route ("/Admin/DeleteModel", name="DeleteModel")
     */
    public function renderModels(): Response {  //TODO: Implement
        //TODO: Load all entries from the database
        //TODO: Load all keywords from the database
        return $this->renderWithBreadcrumbs("Admin/DeleteModel/DeleteModel.html.twig", "Admin area/Delete model", [
            "keywords" => "",
            "models" => ""
        ]);
    }

    /**
     * @Route("/Admin/DeleteModel/CSS", name="DeleteModelCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Admin/DeleteModel.css");
    }

    /**
     * Takes the search parameters given in "models" and "keywords",
     * runs an SQL query returning and then displays all models that were returned by the query
     * @Route ("/Admin/DeleteModel/{models}/{keywords}", name="DeleteModelFiltered")
     */
    public function displaySearchResults(array $models, array $keywords) : Response {   //TODO: Implement
        if ($this->getUser() == null || !UtilFunctions::isAdmin($this->getUser()))
            return $this->render404Page();
        return $this->renderWithBreadcrumbs("Admin/DeleteModel/DeleteModel.html.twig", "Admin area/View models with criteria", [
            "models" => $models,
            "keywords" => $keywords
        ]);
    }
}