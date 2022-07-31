<?php

namespace App\LogIn\Backend;

use App\LogIn\Backend\Entities\Member;
use App\Misc\Backend\FlashType;
use App\Misc\Backend\UtilFunctions;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Twig\Environment;

/**
 * Singleton with Builder Pattern, that creates new Users after registration.
 * Sends new users a confirmation E-Mail with a signed URL.
 */
class UserBuilder {

    /**
     * The instance variable of this singleton.
     */
    public static UserBuilder $instance;

    private EmailVerifier $mailHandler;
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Sets the singleton variable and copies the autowired objects to corresponding fields
     */
    public function __construct(EmailVerifier $mailHandler, UserPasswordHasherInterface $passwordHasher) {
        if (!isset(UserBuilder::$instance))
            UserBuilder::$instance = $this;
        $this->mailHandler = $mailHandler;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Actually does the creation and the Mail sending.
     */
    public function createNewUser(InputBag $data, Environment $twig) : ?Member {
        $newUser = new Member($data->get("Name"), $data->get("Email"));
        $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $data->get('Passwort')));

        AccountDBFacade::$instance->sendChangesToDatabase($newUser, true);

        // generate a signed url and email it to the user
        $this->mailHandler->sendEmailConfirmation($twig, 'RegisterMailVerifier', $newUser,
            (new TemplatedEmail())
                ->from(new Address('eMailBot@biomob.uni-wuerzburg.de', 'BioMoB Account Verification'))
                ->to(new Address($newUser->getEMail(), $newUser->getUsername()))
                ->subject('Please Confirm your humaneness')
                ->htmlTemplate('Misc/EMailText.html.twig')
            );
        return $newUser;
    }

    /**
     * Handles when the user clicks on the signed link in the E-mail.
     * Checks if the link is valid, gets the user and adds flashes based on if the verification was successful
     */
    public function handleEMail(Request $request, TranslatorInterface $translator) :RedirectResponse {
        $id = $request->get('id');

        if (null === $id) {
            UtilFunctions::addFlash($request, FlashType::getErrorType(), "The submitted id " . $id . " was invalid");
            return new RedirectResponse('/LogIn/Register/Retry');
        }

        $user = AccountDBFacade::$instance->find($id);

        if (null === $user)
            return new RedirectResponse('/LogIn/Register/Retry');

        // validate email confirmation link, sets Member::isVerified=true and persists
        try {
            $this->mailHandler->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            UtilFunctions::addFlash($request, FlashType::getErrorType(), $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return new RedirectResponse('/LogIn/Register/Retry');
        }

        UtilFunctions::addFlash($request, FlashType::getSuccessType(), 'Your email address has been verified.');

        return new RedirectResponse("/LogIn/MainMenu");
    }

}