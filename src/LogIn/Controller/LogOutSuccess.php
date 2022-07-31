<?php

namespace App\LogIn\Controller;

use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogOutSuccess extends BaseController {

    /**
     * Never gets called and is only there for autowiring for symfony
     *
     * @Route("/LogOut/Processing", name="LogOutProcess")
     */
    public function handleLogout() : Response {
        return $this->redirect("/LogOut/Success");
    }

    /**
     * @Route("/LogOut/Success", name="LogOutSuccess")
     */
    public function showSuccessMessage() : Response {
        return $this->renderWithBreadcrumbs("LogIn/LogOutSuccess.html.twig", "Log out/Log out successfully");
    }

    /**
     * @Route("/LogOut/CSS", name="LogOutSuccessCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("LogIn/LogOutSuccess.css");
    }

}