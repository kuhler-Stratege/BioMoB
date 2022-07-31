<?php

namespace App\Misc\Controller;

use App\Misc\Backend\ArrayFunctionWrapper;
use App\Misc\Backend\UtilFunctions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController {

    /**
     * Renders a given Twig file and also sets the breadcrumbs variable in the twig template to the given string
     */
    protected function renderWithBreadcrumbs(string $view, string $breadcrumbs, array $parameters = []): Response {
        return parent::render($view, ArrayFunctionWrapper::merge($parameters, ["Breadcrumbs" => $breadcrumbs]));
    }

    public function pathTo404() :string {
        return "/Misc/404Page.html.twig";
    }

    protected function render404Page() : Response {
        return $this->renderWithBreadcrumbs($this->pathTo404(), UtilFunctions::$breadcrumbsRestricted);
    }

    /**
     * @Route("/Misc/404Page/CSS", name="404CSS")
     */
    public function get404CSS() : BinaryFileResponse {
        return $this->loadCSS("Misc/404Page.css");
    }

    /**
     * @Route("/Misc/404Page/Images/404", name="404Image")
     */
    public function get404Image() : BinaryFileResponse {
        $file = new File($this->getParameter("kernel.project_dir") . UtilFunctions::$imageRoot . "Misc/404Page/404-bild.png");
        $response = new BinaryFileResponse($file);
        $response->headers->set("Content-Type", "image/png");
        return $response;
    }

    /**
     * @Route("/Misc/Images/Home", name="HomeImage")
     */
    public function getHomeImage() : Response {
        return $this->loadImage("Misc/Home.svg");
    }

    /**
     * @Route("/Misc/Images/X", name="XImage")
     */
    public function getXImage() : Response {
        return $this->loadImage("Admin/AdminMenu/DeleteModels.svg");
    }

    /**
     * @Route("/Misc/Images/Plus", name="PlusImage")
     */
    public function getPlusImage() : Response {
        return $this->loadImage("LogIn/LogInMenu/Contribute.svg");
    }

    /**
     * @Route("/Misc/Default/CSS", name="DefaultCSS")
     */
    public function getDefaultCSS() : BinaryFileResponse {
        return $this->loadCSS("Misc/Default.css");
    }

    /**
     * @Route("/Misc/Template/CSS", name="TemplateCSS")
     */
    public function getTemplateCSS() : BinaryFileResponse {
        return $this->loadCSS("Misc/Template.css");
    }

    /**
     * @Route("/Misc/FormTemplate/CSS", name="FormTemplateCSS")
     */
    public function getFormTemplateCSS() : BinaryFileResponse {
        return $this->loadCSS("Misc/FormTemplate.css");
    }

    protected function loadCSS(string $filePath) : BinaryFileResponse {
        $file = new File($this->getParameter("kernel.project_dir") . UtilFunctions::$cssRoot . $filePath);
        $response = new BinaryFileResponse($file);
        $response->headers->set("Content-Type", "text/css");
        return $response;
    }

    protected function loadImage(string $filePath) : BinaryFileResponse {
        $file = new File($this->getParameter("kernel.project_dir") . UtilFunctions::$imageRoot . $filePath);
        $response = new BinaryFileResponse($file);
        $response->headers->set("Content-Type", "image/svg+xml");
        return $response;
    }

}