<?php

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
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
        if ($command->courseId) {
            return [
                $this->courseRepository->find($command->courseId)
            ];
        }

        return $this->courseRepository->findAll();
    }
}
