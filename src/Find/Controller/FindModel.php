<?php

namespace App\Find\Controller;

use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindModel extends BaseController {

    /**
     * Redirects the user from the default url to the start Page
     *
     * @Route("/", name="LandingPageRedirector")
     */
    public function startPageRedirect() : Response {
        return $this->redirectToRoute("ModelFinder");
    }

    /**
     * @Route ("/Find/FindModel", name="ModelFinder")
     */
    public function listModels() : Response {  //TODO: Implement
        //TODO: Load models from the database
        return $this->renderWithBreadcrumbs("Find/FindModel.html.twig", "Find model", [
            "keywords" => [],
            "models" => []
        ]);
    }
	
	/**
     * @Route ("/Find/FindModel/ProcessFilter", name="ModelFilterProcessor")
     */
    public function listFilteredModels() : Response {  //TODO: Implement
        //TODO: Filter models from database and display them
        return $this->renderWithBreadcrumbs("Find/FindModel.html.twig", "Find model", [
            "keywords" => [],
            "models" => []
        ]);
    }

	/**
     * @Route ("/Find/FindModel/DownloadData", name="ModelDownloader")
     */
    public function createMetadata() : Response {  //TODO: Implement
        //TODO: Convert all models with all their data and prepare them for download e.x. as Json and return a BinaryFileResponse
        return $this->renderWithBreadcrumbs("Find/FindModel.html.twig", "Find model", [
            "keywords" => [],
            "models" => []
        ]);
    }

    /**
     * @Route("/Find/FindModel/CSS", name="ModelFinderCSS")
     */
    public function getCSSForPage() : BinaryFileResponse {
        return $this->loadCSS("Find/FindModel.css");
    }

    /**
     * @Route("/Find/FindModel/Images/LogIn", name="FindpageLogInImage")
     */
    public function getLogInImage() : BinaryFileResponse {
        return $this->loadImage("Find/FindModel/LogIn.svg");
    }

    /**
     * @Route("/Find/FindModel/Images/Download", name="FindpageDownloadImage")
     */
    public function getDownloadImage() : BinaryFileResponse {
        return $this->loadImage("Find/FindModel/cloud-download.svg");
    }

}