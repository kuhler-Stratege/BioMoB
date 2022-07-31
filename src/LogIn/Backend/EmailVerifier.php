<?php

namespace App\LogIn\Backend;

use App\LogIn\Backend\Entities\Member;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Twig\Environment;
use function dd;

/**
 * Sends automated mails to newly registered users to identify them as real humans
 * Uses a separate Google Account for this with username "BioMoBMailer@gmail.com"
 * Password can be obtained from an administrator
 */
class EmailVerifier {

    private UserAuthenticatorInterface $logInHandler;
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private Mailer $mailer;

    public function __construct(VerifyEmailHelperInterface $helper, UserAuthenticatorInterface $logInHandler) {
        $this->verifyEmailHelper = $helper;
        $this->mailer = new Mailer(new GmailSmtpTransport('BioMoBMailer@gmail.com', 'digwcfynpucmcoic'));
        $this->logInHandler = $logInHandler;
    }

    /**
     * Adds the verification URL to the twig template and an expires date and time.
     * Then sends the confirmation Mail.
     */
    public function sendEmailConfirmation(Environment $twig, string $verifyEmailRouteName, Member $member, TemplatedEmail $email): void {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $member->getUuid(),
            $member->getUuid(),
            ['id' => $member->getUuid()]
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);
        (new BodyRenderer($twig))->render($email);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }
    }

    /**
     * Verifies the member given from the link and signs him in afterwards
     *
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, Member $member): void {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $member->getUuid(), $member->getUuid());
        //Second Parameter needs to be UUID as well, otherwise it wont work anymore

        $member->verifyMember();
        AccountDBFacade::$instance->sendChangesToDatabase($member, true);

        $this->logInHandler->authenticateUser($member, LogInAuthenticator::$instance, $request);

    }

}
