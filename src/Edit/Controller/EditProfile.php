<?php

namespace App\Edit\Controller;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditProfile extends BaseController {

    /**
     * @Route ("/Edit/EditProfile", name="EditProfile")
     */
    public function displayProfileInfo() : Response {
        return $this->renderWithBreadcrumbs("Edit/EditProfile/EditProfile.html.twig", "Logged in area/Edit profile", [
            "username" => $this->getUser()->getUsername(),
            "email" => Member::castToMember($this->getUser())->getEMail()
        ]);
    }

    /**
     * @Route("/Edit/EditProfile/CSS", name="EditProfileCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Edit/EditProfile.css");
    }

}