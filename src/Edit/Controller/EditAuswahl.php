<?php

namespace App\Edit\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditAuswahl extends BaseController {

    /**
     * Filters the models by contributer and
     * returns all models that have the currently signed in user as contributer
     * @Route ("/Edit/EditModels", name="ContributeDBCrawler")
     */
    public function renderFilteredModels() :Response {  //TODO: Implement
        $user = $this->getUser();
        if($user == null || !UtilFunctions::isContributer($user))
            return $this->render404Page();
        //TODO: Load model that have the user as contributer
        return $this->renderWithBreadcrumbs("Edit/EditAuswahl.html.twig", "Logged in area/Edit models", [
            "models" => "",
            "keywords" => ""
        ]);
    }

    /**
     * @Route("/Edit/EditModels/CSS", name="ContributeDBCrawlerCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Edit/EditAuswahl.css");
    }
}