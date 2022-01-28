<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct(
            $entityManager,
            $userRepository
        );

        $this->hasher = $hasher;
    }

    /**
     * @Route("/users", methods={"GET"})
     */
    public function listUsers(Request $request): Response
    {
        return $this->listAll($request);
    }

    /**
     * @Route("/users/{id}", methods={"GET"})
     */
    public function listUser(int $id): Response
    {
        return $this->listOne($id);
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
        $user->setPassword($this->hasher->hashPassword($user,$data->password));

        return $this->createRecord($user);
    }

    /**
     * @Route("/users/{id}", methods={"PUT"})
     */
    public function updateUser(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());

        $userStored = $this->repository->find($id);

        if($userStored === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $userStored->setName($data->name);
        $userStored->setEmail($data->email);
        $userStored->setRoles($data->roles);
        $userStored->setPassword($this->hasher->hashPassword($userStored, $data->password));

        return $this->updateRecord($userStored);
    }

    /**
     * @Route("/users/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        return $this->deleteRecord($id);
    }
}
