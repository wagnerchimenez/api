<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\UseCase\Course\NewCourse;
use App\UseCase\Course\NewCourseHandler;
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
        //return $this->listAll($request);
        return new JsonResponse();
    }

    /**
     * @Route("/courses/{id}", methods={"GET"})
     */
    public function listCourse(int $id): Response
    {
        //return $this->listOne($id);
        return new JsonResponse();
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
            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/courses/{id}", methods={"PUT"})
     */
    public function updateCourse(Request $request, int $id): Response
    {

        return new JsonResponse();
        
        // $data = json_decode($request->getContent());

        // $courseStored = $this->repository->find($id);

        // if ($courseStored === null) {
        //     return new JsonResponse([], Response::HTTP_NOT_FOUND);
        // }

        // $courseStored->setTitle($data->title);
        // $courseStored->setDescription($data->description);
        // $courseStored->setStartDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->start_date));
        // $courseStored->setEndDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->end_date));

        // return $this->updateRecord($courseStored);
    }

    /**
     * @Route("/courses/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        // return $this->deleteRecord($id);
        return new JsonResponse();
    }
}
