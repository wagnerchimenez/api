<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    private UserRepository $repository;
    private UserPasswordHasherInterface $hasher;
    //private ValidatorInterface $validator;

    public function __construct(
        UserRepository $repository, 
        UserPasswordHasherInterface $hasher
        //ValidatorInterface $validator
    )
    {
        $this->repository = $repository;
        $this->hasher = $hasher;
        //$this->validator = $validator;
    }

    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function index(): Response
    {
        $users = $this->repository->findAll();

        return new JsonResponse($users);
    }

    /**
     * @Route("/user", name="user", methods={"POST"})
     */
    public function create(Request $request): Response
    {

        return new JsonResponse([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/user/{id}", name="user", methods={"POST"})
     */
    public function update(Request $request, $id): Response
    {
        $user = $this->repository->find($id);

        if($user === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent());

        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $this->hasher->hashPassword($user,$data->password);

        /*if($this->validator->validate($user)){

        }*/


        $this->repository->flush();

        return new JsonResponse($user, Response::HTTP_CREATED);
    }

    public function delete(): Response
    {
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
