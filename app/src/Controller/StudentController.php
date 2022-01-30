<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\UseCase\Student\DeleteStudent;
use App\UseCase\Student\DeleteStudentHandler;
use App\UseCase\Student\ListStudent;
use App\UseCase\Student\ListStudentHandler;
use App\UseCase\Student\NewStudent;
use App\UseCase\Student\NewStudentHandler;
use App\UseCase\Student\UpdateStudent;
use App\UseCase\Student\UpdateStudentHandler;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class StudentController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private StudentRepository $studentRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        StudentRepository $studentRepository
    ) {
        $this->entityManager = $entityManager;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/students", methods={"GET"})
     */
    public function listStudents(Request $request): Response
    {
        try {
            $command = new ListStudent();

            $handler = new ListStudentHandler(
                $this->studentRepository
            );

            $students = $handler->handle($command);

            return new JsonResponse($students, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/students/{id}", methods={"GET"})
     */
    public function listStudent(int $id): Response
    {
        try {
            $command = new ListStudent(
                $id
            );

            $handler = new ListStudentHandler(
                $this->studentRepository
            );

            $students = $handler->handle($command);

            return new JsonResponse($students, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/students", methods={"POST"})
     */
    public function createStudent(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new NewStudent(
                null,
                $data->name,
                $data->email,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->birthday),
                $data->status
            );

            $handler = new NewStudentHandler(
                $this->studentRepository
            );

            $student = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($student, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return new JsonResponse([], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @Route("/students/{id}", methods={"PUT"})
     */
    public function updateStudent(Request $request, int $id): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new UpdateStudent(
                $id,
                $data->name,
                $data->email,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->birthday),
                $data->status
            );

            $handler = new UpdateStudentHandler(
                $this->studentRepository
            );

            $student = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($student, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/students/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            $command = new DeleteStudent(
                $id
            );

            $handler = new DeleteStudentHandler(
                $this->studentRepository
            );

            $student = $handler->handle($command);

            $this->entityManager->remove($student);            
            $this->entityManager->flush();

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
