<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\UseCase\User\DeleteUser;
use App\UseCase\User\DeleteUserHandler;
use App\UseCase\User\ListUser;
use App\UseCase\User\ListUserHandler;
use App\UseCase\User\NewUser;
use App\UseCase\User\NewUserHandler;
use App\UseCase\User\UpdateUser;
use App\UseCase\User\UpdateUserHandler;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class UserController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users", methods={"GET"})
     */
    public function listUsers(Request $request): Response
    {
        try {
            $command = new ListUser();

            $handler = new ListUserHandler(
                $this->userRepository
            );

            $users = $handler->handle($command);

            return new JsonResponse($users, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function listUser(int $id): Response
    {
        try {
            $command = new ListUser(
                $id
            );

            $handler = new ListUserHandler(
                $this->userRepository
            );

            $users = $handler->handle($command);

            return new JsonResponse($users, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/users", methods={"POST"})
     */
    public function createUser(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new NewUser(
                $data->name,
                $data->email,
                $data->password,
                $data->status
            );

            $handler = new NewUserHandler(
                $this->userRepository
            );

            $user = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($user, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function updateUser(Request $request, int $id): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new UpdateUser(
                $id,
                $data->name,
                $data->email,
                $data->password,
                $data->status
            );

            $handler = new UpdateUserHandler(
                $this->userRepository
            );

            $user = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($user, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            dd($ex->getMessage());
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            $command = new DeleteUser(
                $id
            );

            $handler = new DeleteUserHandler(
                $this->userRepository
            );

            $user = $handler->handle($command);

            $this->entityManager->remove($user);            
            $this->entityManager->flush();

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
