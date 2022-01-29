<?php 

declare(strict_types=1);

namespace App\Service;

use App\Entity\CourseRegistration;
use App\Exceptions\CourseNotFoundException;
use App\Factory\CourseRegistrationFactory;
use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Exception;

class NewCourseRegistrationHandler{

    private CourseRegistrationRepository $courseRegistrationRepository;
    private CourseRepository $courseRepository;
    private StudentRepository $studentRepository;
    private UserRepository $userRepository;

    public function __construct(
        CourseRegistrationRepository $courseRegistrationRepository,
        CourseRepository $courseRepository,
        StudentRepository $studentRepository,
        UserRepository $userRepository
    )
    {
        $this->courseRegistrationRepository = $courseRegistrationRepository;
        $this->courseRepository = $courseRepository;
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(NewCourseRegistration $command): CourseRegistration
    {
        $course = $this->courseRepository->find($command->courseId);

        if($course === null){
            throw new CourseNotFoundException();
        }

        $student = $this->studentRepository->find($command->studentId);

        if ($student === null) {
            throw new Exception('Student not found!');
        }

        if($student->getStatus() === false){
            throw new Exception('Inactive student!');
        }

        $studentAlreadyRegisteredInCourse = $this->courseRegistrationRepository->studentAlreadyRegisteredInCourse($student->getId(), $course->getId());

        if($studentAlreadyRegisteredInCourse){
            throw new Exception('Student Already Registered in Course ' . $course->getTitle() . '!');
        }

        $birthday = $student->getBirthday();
        $today = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $under16 = $birthday->diff($today)->y < 16 ? true : false;

        if($under16){
            throw new Exception('Student under 16!');
        }

        $user = $this->userRepository->find($command->userId);

        if ($user === null) {
            throw new Exception('User not found!');
        }

        $courseInProgressOrClosed = $this->courseRegistrationRepository->courseInProgressOrClosed(
            $course->getId(),
            $command->date->format('Y-m-d')
        );

        if($courseInProgressOrClosed){
            throw new Exception('Course in progress or closed!');
        }

        $totalStudentsInCourse = $this->courseRegistrationRepository->totalStudentsInCourse($course->getId());

        if ($totalStudentsInCourse >= 10) {
            throw new Exception('Limit max 10 students!');
        }

        $courseRegistration = CourseRegistrationFactory::create(
            $course,
            $student,
            $user,
            $command->date
        );

        return $courseRegistration;
    }
}