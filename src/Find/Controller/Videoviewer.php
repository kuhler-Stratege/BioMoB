<?php

namespace App\Find\Controller;

use App\Misc\Controller\BaseController;
use App\Misc\DBFacades\ModelDBFacade;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Videoviewer extends BaseController {

    /**
     * Loads the corresponding video to a model passed via id in "modelID"
     * @Route("/Find/Videoviewer/{modelID}", name="Videoviewer")
     */
    public function loadVideo(int $id) : Response {  //TODO: Implement
        //TODO: Load link to video from database
        $model = ModelDBFacade::$instance->find($id);
        return $this->renderWithBreadcrumbs("Find/Videoviewer/Videoviewer.html.twig", "Find model/Videoviewer", [
            "VideoURL" => "",
            "Breadcrumbs" => "Find Model/ Video for " . $model->getShortName()
        ]);
    }

    /**
     * @Route("/Find/Videoviewerr/CSS", name="VideoviewerCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Find/Videoviewer.css");
    }

    /**
     * @Route("/Find/Videoviewerr/Images/External.svg", name="VideoviewerExternalImage")
     */
    public function getExternalImage() : Response {
        return $this->loadImage("Find/Videoviewer/External.svg");
    }

    /**
     * @Route("/Find/Videoviewerr/Images/Undo.svg", name="VideoviewerUndoImage")
     */
    public function getUndoImage() : Response {
        return $this->loadImage("Find/Videoviewer/Undo.svg");
    }

}