<?php

namespace App\Admin\Controller;

use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMenu extends BaseController{

    /**
     * @Route ("/Admin/Menu", name="AdminMenu")
     */
    public function renderMenu() : Response {
        return $this->renderWithBreadcrumbs("Admin/AdminMenu/AdminMenu.html.twig", "Admin Area/Main menu", [
            "username" => $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/Admin/Menu/Images/BanUser", name="AdminMenuBanUserImg")
     */
    public function getBanUserImage() : Response {
        return $this->loadImage("Admin/AdminMenu/BanUser.svg");
    }

    /**
     * @Route("/Admin/Menu/Images/DeleteModels", name="AdminMenuDeleteModelsImg")
     */
    public function getDeleteModelsImage() : Response {
        return $this->loadImage("Admin/AdminMenu/DeleteModels.svg");
    }

    /**
     * @Route("/Admin/Menu/Images/ListUsers", name="AdminMenuListUsersImg")
     */
    public function getListUsersImage() : Response {
        return $this->loadImage("Admin/AdminMenu/ListUsers.svg");
    }
}