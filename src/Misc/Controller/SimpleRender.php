<?php

namespace App\Misc\Controller;
use App\Misc\Backend\ArrayFunctionWrapper;
use App\Misc\Backend\StringFunctionWrapper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimpleRender extends BaseController {

    /**
     * Method to display any website and test if it renders correctly when using Twig.
     * Works the following:
     * The page path starting from the templates folder must be entered with "-" instead of "/".
     * After a "/" the parameters required by the entered page must be entered in the format:
     * name1-value1;name2-value2
     *
     * @Route("/SimpleRender/{page}/{variableString}", name="SimpleRenderVariables")
     */
    public function simpleRenderVariables(string $page, string $variableString) : Response {
        $variableSplitStrings = StringFunctionWrapper::split($variableString, ";");
        $variables = [];
        foreach($variableSplitStrings as $variableTupleString) {
            $variableTuple = StringFunctionWrapper::split($variableTupleString, "-");
            $variables = ArrayFunctionWrapper::merge($variables, [$variableTuple[0] => $variableTuple[1]]);
        }
        return $this->renderWithBreadcrumbs(StringFunctionWrapper::replace($page, "-", "/") . ".html.twig", "Dummy Render View", $variables);
    }

    /**
     * Same as above but for pages without page variables.
     *
     * @Route("/SimpleRender/{page}", name="SimpleRender")
     */
    public function simpleRender(string $page) : Response {
        return $this->renderWithBreadcrumbs(StringFunctionWrapper::replace($page, "-", "/") . ".html.twig", "Dummy Render View");
    }

}