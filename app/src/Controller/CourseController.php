<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\UseCase\Course\DeleteCourse;
use App\UseCase\Course\DeleteCourseHandler;
use App\UseCase\Course\ListCourse;
use App\UseCase\Course\ListCourseHandler;
use App\UseCase\Course\NewCourse;
use App\UseCase\Course\NewCourseHandler;
use App\UseCase\Course\UpdateCourse;
use App\UseCase\Course\UpdateCourseHandler;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class CourseController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private CourseRepository $courseRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRepository $courseRepository
    ) {
        $this->entityManager = $entityManager;
        $this->courseRepository = $courseRepository;
    }

    /**
     * @Route("/courses", methods={"GET"})
     */
    public function listCourses(Request $request): Response
    {
        try {
            $command = new ListCourse();

            $handler = new ListCourseHandler(
                $this->courseRepository
            );

            $courses = $handler->handle($command);

            return new JsonResponse($courses, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courses/{id}", methods={"GET"})
     */
    public function listCourse(int $id): Response
    {
        try {
            $command = new ListCourse(
                $id
            );

            $handler = new ListCourseHandler(
                $this->courseRepository
            );

            $courses = $handler->handle($command);

            return new JsonResponse($courses, Response::HTTP_OK);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courses", methods={"POST"})
     */
    public function createCourse(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new NewCourse(
                $data->title,
                $data->description,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->start_date),
                DateTimeImmutable::createFromFormat('Y-m-d', $data->end_date)
            );

            $handler = new NewCourseHandler(
                $this->courseRepository
            );

            $course = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($course, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

    /**
     * @Route("/courses/{id}", methods={"PUT"})
     */
    public function updateCourse(Request $request, int $id): Response
    {
        try {
            $data = json_decode($request->getContent());

            $command = new UpdateCourse(
                $id,
                $data->title,
                $data->description,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->start_date),
                DateTimeImmutable::createFromFormat('Y-m-d', $data->end_date)
            );

            $handler = new UpdateCourseHandler(
                $this->courseRepository
            );

            $course = $handler->handle($command);

            $this->entityManager->flush();

            return new JsonResponse($course, Response::HTTP_CREATED);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("/courses/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        try {
            $command = new DeleteCourse(
                $id
            );

            $handler = new DeleteCourseHandler(
                $this->courseRepository
            );

            $course = $handler->handle($command);

            $this->entityManager->remove($course);            
            $this->entityManager->flush();

            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }
    }
}
