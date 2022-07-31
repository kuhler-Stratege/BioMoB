<?php

namespace App\LogIn\Backend;

use App\LogIn\Backend\Entities\Admin;
use App\LogIn\Backend\Entities\Contributer;
use App\LogIn\Backend\Entities\Member;
use App\Misc\Backend\UtilFunctions;
use App\Misc\DBFacades\AccountDBFacade;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * Singleton that logs a user in by searching the database for a user with the given Email from the form.
 * If a user could be found, checks the password for this user and then returns the user object to symfony for signing in
 */
class LogInAuthenticator extends AbstractLoginFormAuthenticator implements AuthenticationEntryPointInterface{
    use TargetPathTrait;

    /**
     * Singleton Variable
     */
    public static LogInAuthenticator $instance;

    private RouterInterface $router;
    private string $failedURL;

    /**
     * Sets the singleton variable and copies the autowired instances to class variables
     */
    public function __construct(AccountDBFacade $dbTable, RouterInterface $router) {
        LogInAuthenticator::$instance = $this;
        $this->router = $router;
        if (AccountDBFacade::$instance == null)
            AccountDBFacade::$instance = $dbTable;
        $this->failedURL = $router->generate("LogInFormular", ["failed" => true]);
    }

    /**
     * Actually does the logging in
     */
    public function authenticate(Request $request): Passport {
        return new Passport(
            new UserBadge("", function() use ($request) {
                $member = AccountDBFacade::$instance->getMemberSigningIn($request);
                if($member == null)
                    throw new UserNotFoundException("Database Problem detected");
                else if(UtilFunctions::isContributer($member))
                    $member = Contributer::castToContributer($member);
                else if (UtilFunctions::isAdmin($member))
                    $member = Admin::castToAdmin($member);
                return $member;
            }),
            new PasswordCredentials($request->request->get('Passwort')), [
                new CsrfTokenBadge('LogInToken', $request->request->get('validate_token')),
            ]
        );
    }

    /**
     * Checks if the user is verified and if so, redirects to main menu.
     * If not, redirects back to the Verify Page.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response {
        if ($token->getUser() == null)
            return new RedirectResponse($this->failedURL);

        if (!Member::castToMember($token->getUser())->isVerified())
            return new RedirectResponse($this->router->generate("RegisterVerifyMessage"));
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName);
        if ($targetPath != null) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->router->generate("LogInMenu"));
    }

    /**
     * Prepares the exception to be shown in the next step and then redirects back to the Log-in Page
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->failedURL);
    }

    /**
     * Entry Point when a User clicked the Log-in Button.
     * Checks if there are errors and redirects to the corresponding page
     */
    public function start(Request $request, AuthenticationException $authException = null) : Response {
        if ($authException != null)
            new RedirectResponse($this->failedURL);
        return new RedirectResponse($this->router->generate("LogInFormular", ["failed" => false]));
    }

    /**
     * This is not the Route with the formula but the Route where the input is processed.
     *
     * @param Request $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string {
        return $this->router->generate("LogInChecker");
    }
}
