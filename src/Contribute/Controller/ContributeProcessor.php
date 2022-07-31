<?php

namespace App\Contribute\Controller;

use App\Misc\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContributeProcessor extends BaseController {

    /**
     * @Route ("/Contribute/FormProcessor", name="ContributeProcessor")
     */
    public function evaluateForm() : Response {  //TODO: Implement
        //TODO: Put data in database
        //TODO: Make User to Contributer
        $number = rand(0, 100000);
        //TODO: check if number is already in use and link to model
        return $this->redirect("/Contribute/SuccessAndLink/" . $number);
    }
}