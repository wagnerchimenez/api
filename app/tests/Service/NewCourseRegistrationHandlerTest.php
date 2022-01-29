<?php 

declare(strict_types=1);

namespace Tests\Service;

use App\Exceptions\CourseNotFoundException;
use App\Repository\CourseRegistrationRepository;
use App\Repository\CourseRepository;
use App\Repository\StudentRepository;
use App\Repository\UserRepository;
use App\Service\NewCourseRegistration;
use App\Service\NewCourseRegistrationHandler;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewCourseRegistrationHandlerTest extends TestCase{

    public function testShouldRegisterStudentInCourse(): void{

        $this->expectException(CourseNotFoundException::class);

        $courseRegistrationRepository = $this->createMock(CourseRegistrationRepository::class);
        $courseRepository = $this->createMock(CourseRepository::class);
        $studentRepository = $this->createMock(StudentRepository::class);
        $userRepository = $this->createMock(UserRepository::class);
        
        $command = new NewCourseRegistration(
            1,
            1,
            1,
            DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'))
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