<?php

declare(strict_types=1);

namespace Tests\UseCase\Course;

use App\Entity\Course;
use App\Repository\InMemoryCourseRepository;
use App\UseCase\Course\NewCourse;
use App\UseCase\Course\NewCourseHandler;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewCourseHandlerTest extends TestCase
{
    public function testShouldAddNewCourse(): void
    {
        $courseRepository = new InMemoryCourseRepository();

        $command = new NewCourse(
            'title',
            'description',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-31'),
        );

        $handler = new NewCourseHandler(
            $courseRepository
        );

        $course = $handler->handle($command);

        $this->assertInstanceOf(Course::class, $course);
        $this->assertNotEmpty($courseRepository->findAll());
    }
}
