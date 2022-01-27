<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private $repository;
    private $hasher;

    public function __construct(UserRepository $repository, UserPasswordHasherInterface $hasher)
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request): Response
    {

        $data = json_decode($request->getContent());

        if (is_null($data->email) || is_null($data->password)) {
            return new JsonResponse([
                'error' => ''
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->repository->findOneBy([
            'email' => $data->email
        ]);

        if(empty($user)){
            return new JsonResponse([
                'error' => ''
            ],
            Response::HTTP_NO_CONTENT);
        };

        if (!$this->hasher->isPasswordValid($user, $data->password)) {
            return new JsonResponse([
                'error' => ''
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = JWT::encode([
            'user' => $user->getEmail()
        ], 'chave', 'HS256');

        return new JsonResponse([
            'access_token' => $token
        ]);
    }
}
