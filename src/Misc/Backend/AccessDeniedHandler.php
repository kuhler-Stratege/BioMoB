<?php

namespace App\Misc\Backend;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Class that defines that if a user gets an Access denied error,
 * it gets redirected to the main menu and
 * a flash is added saying that the user is not allowed to visit the site.
 */
class AccessDeniedHandler implements AccessDeniedHandlerInterface{

    private RouterInterface $routeConverter;

    public function __construct(RouterInterface $routeConverter) {
        $this->routeConverter = $routeConverter;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException) : Response {
        UtilFunctions::addFlash($request, FlashType::getErrorType(), "You are not allowed to visit this website. " . $accessDeniedException->getMessage());
        return new RedirectResponse($this->routeConverter->generate("LogInMenu"));
    }
}