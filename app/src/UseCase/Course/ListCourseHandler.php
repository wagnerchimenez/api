<?php

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
use App\Exceptions\CourseNotFoundException;
use App\Interfaces\CourseInterfaceRepository;

class ListCourseHandler
{
    private CourseInterfaceRepository $courseRepository;

    public function __construct(
        CourseInterfaceRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
    }

    /** @return Course[] */
    public function handle(ListCourse $command): array
    {
        if ($command->courseId === null) {
            return $this->courseRepository->findAll();
        }

        $course = $this->courseRepository->find($command->courseId);

        if ($course === null) {
            throw new CourseNotFoundException();
        }

        return [$course];
    }
}
