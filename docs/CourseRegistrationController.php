<?php

namespace App\Controller;

use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use App\Service\NewCourseRegistration;
use App\Service\NewCourseRegistrationHandler;
use App\Service\UpdateCourseRegistration;
use App\Service\UpdateCourseRegistrationHandler;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class CourseRegistrationController extends BaseController
{
    public const MAX_STUDENTS_PER_COURSE = 10;
    public const ACTIVE_STUDENTS = true;
    public const INACTIVE_STUDENTS = false;

    private CourseRepository $couseRepository;
    private StudentRepository $studentRepository;
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CourseRegistrationRepository $courseRegistrationRepository,
        CourseRepository $courseRepository,
        StudentRepository $studentRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct(
            $entityManager,
            $courseRegistrationRepository
        );

        $this->couseRepository = $courseRepository;
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
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
        try{
            $data = json_decode($request->getContent());

            $command = new NewCourseRegistration(
                (int) $data->course_id,
                (int) $data->student_id,
                (int) $data->user_id,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->date)
            );

            $handler = new NewCourseRegistrationHandler(
                $this->repository,
                $this->couseRepository,
                $this->studentRepository,
                $this->userRepository
            );

            $courseRegistration = $handler->handle($command);

            return $this->createRecord($courseRegistration);

        } catch(Throwable $ex){
            dd($ex->getMessage());
            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
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
                (int) $data->id,
                (int) $data->course_id,
                (int) $data->student_id,
                (int) $data->user_id,
                DateTimeImmutable::createFromFormat('Y-m-d', $data->date)
            );

            $handler = new UpdateCourseRegistrationHandler(
                $this->repository,
                $this->couseRepository,
                $this->studentRepository,
                $this->userRepository
            );

            $courseRegistrationStored = $handler->handle($command);

            return $this->updateRecord($courseRegistrationStored);
        } catch (Throwable $ex) {
            return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/courseregistrations/{id}", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        return $this->deleteRecord($id);
    }
}
