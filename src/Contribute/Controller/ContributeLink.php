<?php

namespace App\Contribute\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributeLink extends BaseController {

    /**
     * Saves the contribute number passed in "number" in the database and renders the success Page
     * @Route ("/Contribute/SuccessAndLink/{number}", name="ContributeLink")
     */
    public function generateLink(int $number) : Response {  //TODO: Implement
        //TODO: Put number in database and wait for video
        return $this->renderWithBreadcrumbs("Contribute/ContributeLink/ContributeLink.html.twig", "Logged in area/Contribute model/Contribute success");
    }

    /**
     * @Route("/Contribute/SuccessAndLinkk/CSS", name="ContributeLinkCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Contribute/ContributeLink.css");
    }

}