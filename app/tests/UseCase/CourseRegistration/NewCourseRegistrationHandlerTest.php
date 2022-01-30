<?php

declare(strict_types=1);

namespace Tests\UseCase\CourseRegistration;

use App\Entity\CourseRegistration;
use App\Exceptions\CourseInProgressOrClosedException;
use App\Factory\CourseFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;
use App\Repository\InMemoryCourseRegistrationRepository;
use App\Repository\InMemoryCourseRepository;
use App\Repository\InMemoryStudentRepository;
use App\Repository\InMemoryUserRepository;
use App\UseCase\CourseRegistration\NewCourseRegistration;
use App\UseCase\CourseRegistration\NewCourseRegistrationHandler;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewCourseRegistrationHandlerTest extends TestCase
{
    public function testShouldAddNewCourseRegistration(): void
    {
        $courseRegistrationRepository = new InMemoryCourseRegistrationRepository();

        $course = CourseFactory::create(
            1,
            'Course 1',
            'description of course',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-02'),
        );

        $courseRepository = new InMemoryCourseRepository([
            $course
        ]);

        $student = StudentFactory::create(
            1,
            'name',
            'email',
            DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
            true
        );

        $studentRepository = new InMemoryStudentRepository([
            $student
        ]);

        $user = UserFactory::create(
            1,
            'name',
            'email',
            'password',
            true
        );

        $userRepository = new InMemoryUserRepository([
            $user
        ]);

        $command = new NewCourseRegistration(
            1,
            1,
            1,
            1,
            DateTimeImmutable::createFromFormat('Y-m-d', '2021-12-31')
        );

        $handler = new NewCourseRegistrationHandler(
            $courseRegistrationRepository,
            $courseRepository,
            $studentRepository,
            $userRepository
        );

        $courseRegistration = $handler->handle($command);

        $this->assertInstanceOf(CourseRegistration::class, $courseRegistration);
        $this->assertEquals($user->getId(), $courseRegistration->getUser()->getId());
    }

    public function testShouldMatriculateOneStudentInManyCourses(): void
    {
        $courseRegistrationRepository = new InMemoryCourseRegistrationRepository();

        $course1 = CourseFactory::create(
            1,
            'Course 1',
            'description of course',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-02'),
        );

        $course2 = CourseFactory::create(
            2,
            'Course 2',
            'description of course',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-02'),
        );

        $courseRepository = new InMemoryCourseRepository([
            $course1,
            $course2
        ]);

        $student = StudentFactory::create(
            1,
            'name',
            'email',
            DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
            true
        );

        $studentRepository = new InMemoryStudentRepository([
            $student
        ]);

        $user = UserFactory::create(
            1,
            'name',
            'email',
            'password',
            true
        );

        $userRepository = new InMemoryUserRepository([
            $user
        ]);

        $command1 = new NewCourseRegistration(
            1,
            1,
            1,
            1,
            DateTimeImmutable::createFromFormat('Y-m-d', '2021-12-31')
        );

        $handler1 = new NewCourseRegistrationHandler(
            $courseRegistrationRepository,
            $courseRepository,
            $studentRepository,
            $userRepository
        );

        $courseRegistration1 = $handler1->handle($command1);

        $command2 = new NewCourseRegistration(
            2,
            2,
            1,
            1,
            DateTimeImmutable::createFromFormat('Y-m-d', '2021-12-31')
        );

        $handler2 = new NewCourseRegistrationHandler(
            $courseRegistrationRepository,
            $courseRepository,
            $studentRepository,
            $userRepository
        );

        $courseRegistration2 = $handler2->handle($command2);

        $this->assertEquals($student->getId(), $courseRegistration1->getStudent()->getId());
        $this->assertEquals($student->getId(), $courseRegistration2->getStudent()->getId());
    }

    public function testShouldNotRegisterStudentInCourseInProgressOrClosed(): void
    {
        $this->expectException(CourseInProgressOrClosedException::class);

        $courseRegistrationRepository = new InMemoryCourseRegistrationRepository();

        $course = CourseFactory::create(
            1,
            'Course 1',
            'description of course',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-02-02'),
        );

        $courseRepository = new InMemoryCourseRepository([
            $course
        ]);

        $student = StudentFactory::create(
            1,
            'name',
            'email',
            DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
            true
        );

        $studentRepository = new InMemoryStudentRepository([
            $student
        ]);

        $user = UserFactory::create(
            1,
            'name',
            'email',
            'password',
            true
        );

        $userRepository = new InMemoryUserRepository([
            $user
        ]);

        $command = new NewCourseRegistration(
            1,
            1,
            1,
            1,
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-15')
        );

        $handler = new NewCourseRegistrationHandler(
            $courseRegistrationRepository,
            $courseRepository,
            $studentRepository,
            $userRepository
        );

        $handler->handle($command);
    }
}
