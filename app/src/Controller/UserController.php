<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * @Route("/users", methods={"GET"})
     */
    public function listUsers(): Response
    {
        $users = $this->userRepository->findAll();

        return new JsonResponse($users, Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function listUser(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if($user === null){
            return new JsonResponse([],Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($user, Response::HTTP_OK);
    }


    /**
     * @Route("/users", methods={"POST"})
     */
    public function createUser(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $user = new User();
        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setRoles($data->roles);
        $user->setPassword($this->hasher->hashPassword($data->password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function updateUser(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());

        $userStored = $this->userRepository->find($id);

        if($userStored === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $userStored->setName($data->name);
        $userStored->setEmail($data->email);
        $userStored->setRoles($data->roles);
        $userStored->setPassword($this->hasher->hashPassword($data->password));

        $this->entityManager->flush();

        return new JsonResponse($userStored, Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $user = $this->userRepository->find($id);

        if($user === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
