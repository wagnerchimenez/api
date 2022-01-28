<?php

namespace App\Controller;

use App\Interfaces\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    
    protected ObjectRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ObjectRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    protected function listAll(Request $request): Response
    {
        $records = $this->repository->findAll();

        return new JsonResponse($records, Response::HTTP_OK);
    }

    protected function listOne(int $id): Response
    {
        $record = $this->repository->find($id);

        if ($record === null) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($record, Response::HTTP_OK);
    }

    protected function createRecord(EntityInterface $object): Response
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();

        return new JsonResponse($object, Response::HTTP_CREATED);
    }

    protected function updateRecord(EntityInterface $object): Response
    {
        $this->entityManager->flush();
        return new JsonResponse($object, Response::HTTP_OK);
    }

    protected function deleteRecord($id): Response
    {
        $record = $this->repository->find($id);

        if ($record === null) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($record);
        $this->entityManager->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }    
}
