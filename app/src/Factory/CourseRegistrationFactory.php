<?php 

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Course;
use App\Entity\CourseRegistration;
use App\Entity\Student;
use App\Entity\User;
use DateTimeImmutable;

class CourseRegistrationFactory{

    private Course $course;
    private Student $student;
    private User $user;
    private DateTimeImmutable $date;

    private function __construct(
        Course $course,
        Student $student,
        User $user,
        DateTimeImmutable $date
    )
    {
        $this->course = $course;
        $this->student = $student;
        $this->user = $user;
        $this->date = $date;
    }

    public static function create(
        Course $course,
        Student $student,
        User $user,
        DateTimeImmutable $date
    ) : CourseRegistration{

        $courseRegistration = new CourseRegistration();
        $courseRegistration->setCourse($course);
        $courseRegistration->setStudent($student);
        $courseRegistration->setUser($user);
        $courseRegistration->setDate($date);

        return $courseRegistration;
    }
}