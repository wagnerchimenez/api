<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends BaseController
{
    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRepository $courseRepository
    )
    {
        parent::__construct(
            $entityManager,
            $courseRepository
        );
    }

    /**
     * @Route("/courses", methods={"GET"})
     */
    public function listCourses(Request $request): Response
    {
        return $this->listAll($request);
    }

    /**
     * @Route("/courses/{id}", methods={"GET"})
     */
    public function listCourse(int $id): Response
    {
        return $this->listOne($id);
    }

    /**
     * @Route("/courses", methods={"POST"})
     */
    public function createCourse(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $course = new Course();
        $course->setTitle($data->title);
        $course->setDescription($data->description);
        $course->setStartDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->start_date));
        $course->setEndDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->end_date));

        return $this->createRecord($course);
    }

    /**
     * @Route("/courses/{id}", methods={"PUT"})
     */
    public function updateCourse(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());

        $courseStored = $this->repository->find($id);

        if($courseStored === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $courseStored->setTitle($data->title);
        $courseStored->setDescription($data->description);
        $courseStored->setStartDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->start_date));
        $courseStored->setEndDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->end_date));

        return $this->updateRecord($courseStored);
    }

    /**
     * @Route("/courses/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        return $this->deleteRecord($id);
    }
}
