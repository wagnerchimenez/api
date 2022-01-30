<?php

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
use App\Exceptions\CourseNotFoundException;
use App\Interfaces\CourseInterfaceRepository;

class DeleteCourseHandler
{
    private CourseInterfaceRepository $courseRepository;

    public function __construct(
        CourseInterfaceRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
    }

    public function handle(DeleteCourse $command): Course
    {
        $course = $this->courseRepository->find($command->courseId);

        if ($course === null) {
            throw new CourseNotFoundException();
        }

        return $course;
    }
}
