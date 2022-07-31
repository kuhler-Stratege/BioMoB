<?php

namespace App\Edit\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditForm extends BaseController {

    /**
     * Loads and fills all modeldata corresponding to the model passed by id in "id" and displays edit page
     * @Route ("/Edit/EditModel/{modelID}", name="EditForm")
     */
    public function editModel(int $id) : Response {  //TODO: Implement and debug
        if ($this->getUser() == null || !UtilFunctions::isContributer($this->getUser()))
            return $this->render404Page();
        //TODO: Load model data from database
        $model = null;
        return $this->renderWithBreadcrumbs("Edit/EditForm/EditForm.html.twig", "Logged in area/Edit models/Edit model " /*. $model->name*/, [
            "Username" => "",
            "contributers" => ""  //TODO: Other Contributers wont be displayed
        ]);
    }

     /**
      * Compares all fields with the database fields and saves changes to the database.
      * After that, redirects to the selection page
      *   @Route("Edit/EditModell/ProcessChanges", name="EditFormProcessor")
      */
     public function processChanges() : Response {  //TODO: Implement
            return $this->redirect("/Edit/EditAuswahl");
     }

    /**
     * @Route("/Edit/EditModel/CSS", name="ContributerModelEditorCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Edit/EditForm.css");
    }

}