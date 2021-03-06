<?php

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
use App\Exceptions\CourseNotFoundException;
use App\Factory\CourseFactory;
use App\Interfaces\CourseInterfaceRepository;

class UpdateCourseHandler
{
    private CourseInterfaceRepository $courseRepository;

    public function __construct(
        CourseInterfaceRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
    }

    public function handle(UpdateCourse $command): Course
    {
        $course = $this->courseRepository->find($command->courseId);

        if ($course === null) {
            throw new CourseNotFoundException();
        }

        $course->setTitle($command->title);
        $course->setDescription($command->description);
        $course->setStartDate($command->startDate);
        $course->setEndDate($command->endDate);

        return $course;
    }
}
