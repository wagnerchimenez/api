<?php

namespace App\Controller;

use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use App\UseCase\CourseRegistration\DeleteCourseRegistration;
use App\UseCase\CourseRegistration\DeleteCourseRegistrationHandler;
use App\UseCase\CourseRegistration\ListCourseRegistration;
use App\UseCase\CourseRegistration\ListCourseRegistrationHandler;
use App\UseCase\CourseRegistration\NewCourseRegistration;
use App\UseCase\CourseRegistration\NewCourseRegistrationHandler;
use App\UseCase\CourseRegistration\UpdateCourseRegistration;
use App\UseCase\CourseRegistration\UpdateCourseRegistrationHandler;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class CourseRegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private CourseRegistrationRepository $courseRegistrationRepository;
    private CourseRepository $courseRepository;
    private StudentRepository $studentRepository;
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRegistrationRepository $courseRegistrationRepository,
        CourseRepository $courseRepository,
        StudentRepository $studentRepository,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->courseRegistrationRepository = $courseRegistrationRepository;
        $this->courseRepository = $courseRepository;
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/courseregistrations", methods={"GET"})
     */
    public function listCourseRegistrations(Request $request): Response
    {
        try {
            $command = new ListCourseRegistration();

            $handler = new ListCourseRegistrationHandler(
                $this->courseRegistrationRepository
            );

            $courseRegistrations = $handler->handle($command);

            return new JsonResponse($courseRegistrations, Response::HTTP_OK);
        } catch (Throwable $ex) {
            dd($ex->getMessage());
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"GET"})
     */
    public function listCourseRegistration(int $id): Response
    {
        try {
            $command = new ListCourseRegistration(
                $id
            );

            $handler = new ListCourseRegistrationHandler(
                $this->courseRegistrationRepository
            );

            $courseRegistrations = $handler->handle($command);

            return new JsonResponse($courseRegistrations, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courseregistrations", methods={"POST"})
     */
    public function createCourseRegistration(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new NewCourseRegistration(
                null,
                $data->course_id,
                $data->student_id,
                $data->user_id,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->date)
            );

            $handler = new NewCourseRegistrationHandler(
                $this->courseRegistrationRepository,
                $this->courseRepository,
                $this->studentRepository,
                $this->userRepository
            );

            $courseRegistration = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($courseRegistration, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"PUT"})
     */
    public function updateCourseRegistration(Request $request, int $id): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new UpdateCourseRegistration(
                $id,
                $data->course_id,
                $data->student_id,
                $data->user_id,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->date)
            );

            $handler = new UpdateCourseRegistrationHandler(
                $this->courseRegistrationRepository,
                $this->courseRepository,
                $this->studentRepository,
                $this->userRepository
            );

            $courseRegistration = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($courseRegistration, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            $command = new DeleteCourseRegistration(
                $id
            );

            $handler = new DeleteCourseRegistrationHandler(
                $this->courseRegistrationRepository
            );

            $courseRegistration = $handler->handle($command);

            $this->entityManager->remove($courseRegistration);            
            $this->entityManager->flush();

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
