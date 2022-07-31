<?php

namespace App\Edit\Controller;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Controller\BaseController;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordAndern extends BaseController {

    /**
     * @Route("/Edit/Password", name="PasswordAndern")
     */
    public function renderPasswordSite() : Response {
        return $this->renderWithBreadcrumbs("Edit/EditPassword/PasswordAndern.html.twig", "Logged in area/Edit profile/Change password", [
            "wrongPassword" => false
        ]);
    }

    /**
     * Calls a backend class to Hash and check the old and the new Password and sends it to the database
     * @Route("/Edit/Password/Apply", name="CheckPassword")
     */
    public function checkNewPassword(Request $request) : Response {  //TODO: Implement
        $isPasswordCorrect = true;
        if ($isPasswordCorrect)
            return $this->renderWithBreadcrumbs("Edit/EditSuccess/EditSuccess.html.twig", "Logged in area/Edit profile/Password changed");
        else
            return $this->renderWithBreadcrumbs("Edit/EditPassword/PasswordAndern.html.twig", "Logged in area/Edit profile/Change password", [
                "wrongPassword" => true
            ]);
    }

    /**
     * @Route("/Edit/Password/CSS", name="CheckPasswordCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Edit/PasswordAndern.css");
    }

}