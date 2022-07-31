<?php

namespace App\Admin\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListUsers extends BaseController {

    /**
     * Loads all users from the database and displays them
     * @Route ("/Admin/ListUsers", name="ListUsers")
     */
    public function listUsers() : Response {  //TODO: Implement
        //TODO: Load all user data from the database
        return $this->renderWithBreadcrumbs("Admin/ListUsers.html.twig", "Admin area/List users", [
            "models" => "",
            "users" => ""
        ]);
    }

     /**
     * @Route("/Admin/ListUsers/Filtered", name="ListFilteredUsers")
     */
      public function filterUsers() : Response {   //TODO: Implement
              //TODO: Filter by criteria
              return $this->renderWithBreadcrumbs("Admin/ListUsers.html.twig", "List filtered Users");
       }

    /**
     * @Route("/Admin/ListUsers/CSS", name="ListUsersCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Admin/ListUsers.css");
    }

}