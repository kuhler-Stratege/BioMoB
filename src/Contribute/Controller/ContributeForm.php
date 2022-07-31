<?php

namespace App\Contribute\Controller;

use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributeForm extends BaseController {

    /**
     * Loads all keywords from the database and renders the contribute form
     * @Route("/Contribute", name="ContributeForm")
     */
    public function createContributeForm() : Response {  //TODO: Debug
        return $this->renderWithBreadcrumbs("Contribute/ContributeForm.html.twig", "Logged in area/Contribute model", [
            "keywords" => [  //TODO: Dummykeyword is not getting passed
            ]
        ]);
    }

    /**
     * @Route("/Contribute/Images/Questionmark", name="ContributeQuestionmarkImage")
     */
    public function getQuestionmarkImage() : Response {
        return $this->loadImage("Contribute/ContributeForm/Questionmark.svg");
    }

    /**
     * @Route("/Contribute/CSS", name="ContributeFormCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Admin/DeleteModel.css");
    }
}