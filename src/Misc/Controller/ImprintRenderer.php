<?php

namespace App\Misc\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImprintRenderer extends BaseController {

    /**
     * @Route("/Imprint", name="ImprintRenderer")
     */
    public function renderImprint() : Response {
        return $this->renderWithBreadcrumbs("Misc/Imprint.html.twig", "Imprint");
    }

    /**
     * @Route("/Imprint/CSS", name="InprintRendererCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("Misc/Imprint.css");
    }

}