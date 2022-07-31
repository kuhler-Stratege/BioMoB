<?php

namespace App\LogIn\Controller;

use App\LogIn\Backend\UserBuilder;
use App\Misc\Backend\FlashType;
use App\Misc\Backend\UtilFunctions;
use App\Misc\Controller\BaseController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterRenderer extends BaseController {

    public function __construct(UserBuilder $builder) {
        if (!isset(UserBuilder::$instance))
            UserBuilder::$instance = $builder;
    }

    /**
     * @Route("/LogIn/Register", name="RegisterFormRenderer")
     */
    public function renderRegisterForm() : Response {
        return $this->renderWithBreadcrumbs("LogIn/Register.html.twig", "Find model/Register");
    }

    /**
     * Same like method above, but adds a flash with an error message
     *
     * @Route("/LogIn/Register/Retry", name="RetryRegister")
     */
    public function showRegistrationError(Request $request) : Response {
        UtilFunctions::addFlash($request, FlashType::getErrorType(), "Something went wrong during registration. Please try again.");
        return $this->renderWithBreadcrumbs("LogIn/Register.html.twig", "Find model/Register");
    }

    /**
     * Starts processing form input from registration and calls the backend class for further processing
     *
     * @Route("/LogIn/Register/processData", name="UserCreator")
     */
    public function createNewUser(Request $request) : Response {
        try {
            $newUser = UserBuilder::$instance->createNewUser($request->request, $this->container->get('twig'));
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            return $this->redirect("/LogIn/Register/Retry");
        }
        if ($newUser != null)
            return $this->redirect("/LogIn/Register/VerifyMessage");
        else
            return $this->redirect("/LogIn/Register/Retry");
    }

    /**
     * @Route("/LogIn/Register/VerifyMessage", name="RegisterVerifyMessage")
     */
    public function displayVerifyMessage() : Response {
        return $this->renderWithBreadcrumbs("LogIn/EmailVerifyMessage.html.twig", "Find model/Register/Verify your humaneness");
    }

    /**
     * User lands here when he clicked on the link in the E-Mail. Request is forwarded to backend class.
     *
     * @Route("/LogIn/Register/VerifyMail", name="RegisterMailVerifier")
     */
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): RedirectResponse {
        return UserBuilder::$instance->handleEMail($request, $translator);
    }

    /**
     * @Route("/LogIn/Register/CSS", name="RegisterFormRendererCSS")
     */
    public function getCSSForPage() : BinaryFileResponse {
        return $this->loadCSS("Admin/DeleteModel.css");
    }
}