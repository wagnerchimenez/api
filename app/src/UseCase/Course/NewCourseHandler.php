<?php 

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
use App\Factory\CourseFactory;
use App\Interfaces\CourseInterfaceRepository;

class NewCourseHandler
{
    private CourseInterfaceRepository $courseRepository;

    public function __construct(
        CourseInterfaceRepository $courseRepository
    )
    {
        $this->courseRepository = $courseRepository;
    }

    public function handle(NewCourse $command) : Course
    {

        $course = CourseFactory::create(
            $command->title,
            $command->description,
            $command->startDate,
            $command->endDate
        );

        $this->courseRepository->save($course);

        return $course;

    }
}