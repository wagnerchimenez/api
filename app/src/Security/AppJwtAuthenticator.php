<?php

namespace App\Security;

use App\Exceptions\UserNotFoundException;
use App\Repository\UserRepository;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Throwable;

class AppJwtAuthenticator extends AbstractAuthenticator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): ?bool
    {
        // TODO: Implement supports() method.
        return $request->getPathInfo() !== '/login';
    }

    public function authenticate(Request $request): Passport
    {
        try {

            $apiToken = \getallheaders();

            if (!isset($apiToken['Authorization']) || is_null($apiToken['Authorization'])) {
                // The token header was empty, authentication fails with HTTP Status
                // Code 401 "Unauthorized"
                throw new Exception('No API token provided');
            }

            $apiToken = $apiToken['Authorization'];
            $apiToken = trim(str_replace('Bearer', '', $apiToken));
            $apiToken = JWT::decode($apiToken,  new Key('chave', 'HS256'));

            return new SelfValidatingPassport(new UserBadge($apiToken->user, function ($userIdentifier) {
                $user = $this->userRepository->findOneBy(['email' => $userIdentifier]);

                if (!$user) {
                    throw new UserNotFoundException();
                }

                return $user;
            }));
        } catch (Throwable $ex) {
            echo 'Sorry, Unauthorized!';
            exit;
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // TODO: Implement onAuthenticationSuccess() method.
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // TODO: Implement onAuthenticationFailure() method.
        return new JsonResponse(
            [
                'error' => 'Authentication failure!'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    //    public function start(Request $request, AuthenticationException $authException = null): Response
    //    {
    //        /*
    //         * If you would like this class to control what happens when an anonymous user accesses a
    //         * protected page (e.g. redirect to /login), uncomment this method and make this class
    //         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
    //         *
    //         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //         */
    //    }
}
