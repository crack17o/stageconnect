<?php

namespace App\Controller\Security;

use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;

class AuthenticationAuthenticator extends AbstractLoginFormAuthenticator
{
    public const LOGIN_ROUTE = 'app_login';

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $password = $request->request->get('password', '');
        $csrfToken = $request->request->get('_csrf_token');

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): RedirectResponse
    {
        /** @var UserInterface $user */
        $user = $token->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_SUPERADMIN', $roles, true)) {
            return new RedirectResponse($this->router->generate('superadmin_dashboard'));
        }
        if (in_array('ROLE_ENTREPRISE', $roles, true)) {
            return new RedirectResponse($this->router->generate('company_dashboard'));
        }
        if (in_array('ROLE_SUPERVISEUR', $roles, true)) {
            return new RedirectResponse($this->router->generate('supervisor_dashboard'));
        }
        if (in_array('ROLE_ETUDIANT', $roles, true)) {
            return new RedirectResponse($this->router->generate('student_dashboard'));
        }

        // Default fallback
        return new RedirectResponse($this->router->generate('app_stage_connect'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN_ROUTE);
    }
}