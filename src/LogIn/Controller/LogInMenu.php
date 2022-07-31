<?php

namespace App\LogIn\Controller;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogInMenu extends BaseController {

    /**
     * @Route("/LogIn/MainMenu", name="LogInMenu")
     */
    public function renderMenu() : Response {
        return $this->renderWithBreadcrumbs("LogIn/LogInMenu.html.twig", "Logged in area/Main menu", [
           "username" => Member::castToMember($this->getUser())->getUsername()
        ]);
    }

    /**
     * @Route("/LogIn/MainMenu/CSS", name="LogInMenuCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("LogIn/LogInMenu.css");
    }

    /**
     * @Route("/LogIn/MainMenu/Images/Contribute.svg", name="LogInMenuContributeImage")
     */
    public function getContributeImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/Contribute.svg");
    }

    /**
     * @Route("/LogIn/MainMenu/Images/EditModels", name="LogInMenuEditModelsImage")
     */
    public function getEditModelsImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/EditModels.svg");
    }

    /**
     * @Route("/LogIn/LogInMenu/Images/EditProfile", name="LogInMenuEditProfileImage")
     */
    public function getEditProfileImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/EditProfile.svg");
    }

    /**
     * @Route("/LogOut/Images/LogOut", name="LogInMenuLogOutImage")
     */
    public function getLogOutImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/LogOut.svg");
    }

    /**
     * @Route("/LogIn/LogInMenu/Images/Magnifier", name="LogInMenuMagnifierImage")
     */
    public function getMagnifierImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/Magnifier.svg");
    }

}