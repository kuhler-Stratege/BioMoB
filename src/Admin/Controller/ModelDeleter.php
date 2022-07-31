<?php

namespace App\Admin\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModelDeleter extends BaseController {

    /**
     * Deletes a model given via id in "deletedModel" and redirects to the display afterwards
     * @Route ("/Admin/DeleteProcess/{deletedModel}", name="ModelDeleter")
     */
    public function index(string $deletedModel) : Response {  //TODO: Implement
        return $this->redirectToRoute("DeleteModel");
    }
}