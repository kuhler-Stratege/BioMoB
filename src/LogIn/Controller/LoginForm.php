<?php

namespace App\LogIn\Controller;

use App\LogIn\Backend\LogInAuthenticator;
use App\Misc\Backend\FlashType;
use App\Misc\Backend\StringFunctionWrapper;
use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginForm extends BaseController {

    /**
     * A helper for saving the last authentication error throughout sessions
     */
    private AuthenticationUtils $authUtils;

    /**
     * Checks if the Singleton worked and if not, sets singleton variables to corresponding autowired object
     */
    public function __construct(AccountDBFacade $dbFacade, LogInAuthenticator $auth, AuthenticationUtils $authUtils) {
        if (AccountDBFacade::$instance == null)
            AccountDBFacade::$instance = $dbFacade;
        if(LogInAuthenticator::$instance == null)
            LogInAuthenticator::$instance = $auth;
        $this->authUtils = $authUtils;
    }

    /**
     * Renders the last authentication Error if logging in failed, which is passed as "failed" variable.
     * After that, renders the log-in formula.
     *
     * @Route("/LogInn/{failed}", name="LogInFormular")
     */
    public function renderLoginPage(bool $failed, Request $request) : Response {
        if ($failed) {
            $errorMessage = "An Error happened during log in, please try again ";
            $exception = $this->authUtils->getLastAuthenticationError();
            if ($exception != null)
                $errorMessage = $errorMessage . $exception->getMessage();
            UtilFunctions::addFlash($request, FlashType::getErrorType(), $errorMessage);
        }
        return $this->renderWithBreadcrumbs("LogIn/LogInForm.html.twig", "Find model/Log in");
    }

    /**
     * Method should never be called and is only there for emergency and for autowiring
     *
     * @Route("/LogIn/ProcessLogIn", name="LogInChecker")
     */
    public function checkLogInData(Request $request, AuthenticationUtils $authenticator) : Response {
        if ($this->getUser() != null) {
            return $this->redirectToRoute('LogInMenu');
        }
        // get the login error if there is one
        $error = $authenticator->getLastAuthenticationError();

        if ($error == null) {
            return $this->redirectToRoute("LogInMenu");
        }
        else {
            UtilFunctions::addFlash($request, FlashType::getErrorType(), "An error happened during log in, please try again: " . $error->getMessage());
            return $this->redirectToRoute("LogInFormular", ["failed" => true]);
        }
    }

    /**
     * @Route("/LogIn/CSS", name="LogInCSS")
     */
    public function getCSSForPage() : Response {
        return $this->loadCSS("LogIn/LogInForm.css");
    }

}