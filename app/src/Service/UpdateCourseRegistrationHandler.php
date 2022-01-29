<?php 

declare(strict_types=1);

namespace App\Service;

use App\Entity\CourseRegistration;
use App\Factory\CourseRegistrationFactory;
use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Exception;

class UpdateCourseRegistrationHandler{

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

    public function handle(UpdateCourseRegistration $command): CourseRegistration
    {
        $courseRegistrationStored = $this->courseRegistrationRepository->find($command->courseRegistrationId);

        if($courseRegistrationStored === null){
            throw new Exception('Course register not found!');
        }

        $course = $this->courseRepository->find($command->course_id);

        if($course === null){
            throw new Exception('Course not found!');
        }

        $student = $this->studentRepository->find($command->student_id);

        if ($student === null) {
            throw new Exception('Student not found!');
        }

        if($student->getStatus() === false){
            throw new Exception('Inactive student!');
        }

        $birthday = $student->getBirthday();
        $today = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $under16 = $birthday->diff($today)->y < 16 ? true : false;

        if($under16){
            throw new Exception('Student under 16!');
        }

        $user = $this->userRepository->find($command->id);

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

        return $courseRegistrationStored;
    }
}