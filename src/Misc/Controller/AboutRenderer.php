<?php

namespace App\Misc\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutRenderer extends BaseController {
    /**
     * @Route("/About", name="AboutRenderer")
     */
    public function renderAbout() : Response {
        return $this->renderWithBreadcrumbs("Misc/About.html.twig", "About");
    }

    /**
     * @Route("/About/CSS", name="AboutCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Misc/About.css");
    }

}