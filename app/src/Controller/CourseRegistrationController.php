<?php

namespace App\Controller;

use App\Entity\CourseRegistration;
use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseRegistrationController extends BaseController
{
    private CourseRepository $couseRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRegistrationRepository $courseRegistrationRepository,
        CourseRepository $courseRepository
    )
    {
        parent::__construct(
            $entityManager,
            $courseRegistrationRepository
        );

        $this->couseRepository = $courseRepository;
    }

    /**
     * @Route("/courseregistrations", methods={"GET"})
     */
    public function listCourseRegistrations(Request $request): Response
    {
        return $this->listAll($request);
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"GET"})
     */
    public function listCourseRegistration(int $id): Response
    {
        return $this->listOne($id);
    }

    /**
     * @Route("/courseregistrations", methods={"POST"})
     */
    public function createCourseRegistration(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $course = $this->couseRepository->find($data->course_id);

        if ($course === null) {
            return new JsonResponse([],Response::HTTP_BAD_REQUEST);
        }

        $student = $this->studentRepository->find($data->student_id);

        if ($student === null) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->find($data->user_id);

        if ($user === null) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $courseRegistration = new CourseRegistration();
        $courseRegistration->setCourse($course);
        $courseRegistration->setStudent($student);
        $courseRegistration->setUser($user);
        $courseRegistration->setDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->date));

        return $this->createRecord($courseRegistration);
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"PUT"})
     */
    public function updateCourseRegistration(Request $request, int $id): Response
    {
        $data = json_decode($request->getContent());

        $courseRegistrationStored = $this->repository->find($id);

        if($courseRegistrationStored === null){
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }

        $course = $this->couseRepository->find($data->course_id);

        if ($course === null) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $student = $this->studentRepository->find($data->student_id);

        if ($student === null) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userRepository->find($data->user_id);

        if ($user === null) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $courseRegistrationStored->setCourse($course);
        $courseRegistrationStored->setStudent($student);
        $courseRegistrationStored->setUser($user);
        $courseRegistrationStored->setDate(DateTimeImmutable::createFromFormat('Y-m-d', $data->date));

        return $this->updateRecord($courseRegistrationStored);
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        return $this->deleteRecord($id);
    }

}
