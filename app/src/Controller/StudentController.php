<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        StudentRepository $studentRepository
    )
    {
        parent::__construct(
            $entityManager,
            $studentRepository
        );
    }

    /**
     * @Route("/students", methods={"GET"})
     */
    public function listStudents(Request $request): Response
    {
        return $this->listAll($request);
    }

    /**
     * @Route("/students/{id}", methods={"GET"})
     */
    public function listStudent(int $id): Response
    {
        return $this->listOne($id);
    }

    /**
     * @Route("/students", methods={"POST"})
     */
    public function createStudent(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $student = new Student();
        $student->setName($data->name);
        $student->setEmail($data->email);
        $student->setBirthday(DateTimeImmutable::createFromFormat('Y-m-d', $data->birthday));
        $student->setStatus($data->status);

        return $this->createRecord($student);
    }

    /**
     * @Route("/students/{id}", methods={"PUT"})
     */
    public function updateStudent(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());

        $studentStored = $this->repository->find($id);

        if($studentStored === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $studentStored->setName($data->name);
        $studentStored->setEmail($data->email);
        $studentStored->setBirthday(DateTimeImmutable::createFromFormat('Y-m-d', $data->birthday));
        $studentStored->setStatus($data->status);

        return $this->updateRecord($studentStored);
    }

    /**
     * @Route("/students/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        return $this->deleteRecord($id);
    }
}