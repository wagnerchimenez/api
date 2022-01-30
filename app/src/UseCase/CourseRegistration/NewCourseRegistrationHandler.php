<?php 

declare(strict_types=1);

namespace App\UseCase\CourseRegistration;

use App\Entity\CourseRegistration;
use App\Exceptions\CourseInProgressOrClosedException;
use App\Exceptions\CourseNotFoundException;
use App\Exceptions\CourseRegistrationAlreadyExistsException;
use App\Exceptions\CourseRegistrationMaxLimitException;
use App\Exceptions\StudentInactiveException;
use App\Exceptions\StudentNotFoundException;
use App\Exceptions\StudentUnder16Exception;
use App\Exceptions\UserNotFoundException;
use App\Factory\CourseRegistrationFactory;
use App\Interfaces\CourseInterfaceRepository;
use App\Interfaces\CourseRegistrationInterfaceRepository;
use App\Interfaces\StudentInterfaceRepository;
use App\Interfaces\UserInterfaceRepository;
use DateTimeImmutable;
use Exception;

class NewCourseRegistrationHandler{

    private CourseRegistrationInterfaceRepository $courseRegistrationRepository;
    private CourseInterfaceRepository $courseRepository;
    private StudentInterfaceRepository $studentRepository;
    private UserInterfaceRepository $userRepository;

    public function __construct(
        CourseRegistrationInterfaceRepository $courseRegistrationRepository,
        CourseInterfaceRepository $courseRepository,
        StudentInterfaceRepository $studentRepository,
        UserInterfaceRepository $userRepository
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
            throw new StudentNotFoundException();
        }

        if($student->getStatus() === false){
            throw new StudentInactiveException();
        }

        $studentAlreadyRegisteredInCourse = $this->courseRegistrationRepository->studentAlreadyRegisteredInCourse($student->getId(), $course->getId());

        if($studentAlreadyRegisteredInCourse){
            throw new Exception('Student Already Registered in Course ' . $course->getTitle() . '!');
        }

        $birthday = $student->getBirthday();
        $today = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $under16 = $birthday->diff($today)->y < 16 ? true : false;

        if($under16){
            throw new StudentUnder16Exception();
        }

        $user = $this->userRepository->find($command->userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $courseStartDate = strtotime($course->getStartDate()->format('Y-m-d'));
        $courseEndDate = strtotime($course->getEndDate()->format('Y-m-d'));
        $dateCompare = strtotime($command->date->format('Y-m-d'));

        if(
            ($dateCompare >= $courseStartDate && $dateCompare <= $courseEndDate) || $dateCompare > $courseEndDate
        ){
            throw new CourseInProgressOrClosedException();
        }

        $totalStudentsInCourse = $this->courseRegistrationRepository->totalStudentsInCourse($course->getId());

        if ($totalStudentsInCourse >= 10) {
            throw new CourseRegistrationMaxLimitException();
        }

        

        $courseRegistration = CourseRegistrationFactory::create(
            $command->courseRegistrationId,
            $course,
            $student,
            $user,
            $command->date
        );

        $this->courseRegistrationRepository->save($courseRegistration);

        return $courseRegistration;
    }
}