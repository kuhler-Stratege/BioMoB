<?php

namespace App\Edit\Controller;

use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

class ProfileUpdater extends BaseController {

    /**
     * Checks for changes in the given form and sends the changes to the database
     * @Route("/Edit/EditProfile/Update", name="UserprofileUpdater")
     */
    public function updateProfile() : Response {
        //TODO: Process changed input
        return $this->renderWithBreadcrumbs("Edit/EditSuccess.html.twig", "Logged in area/Edit profile/Profile updated");
    }

    /**
     * @Route("/Edit/EditProfile/Update/CSS/", name="UserprofilerUpdaterCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Edit/EditSuccess.css");
    }

}