<?php 

declare(strict_types=1);

namespace App\UseCase\Course;

use App\Entity\Course;
use App\Exceptions\CourseNotFoundException;
use App\Factory\CourseFactory;
use App\Interfaces\CourseInterfaceRepository;
use App\Repository\AbstractRepository;

class UpdateCourseHandler
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
        $course = $this->courseRepository->find($command->courseId);

        if($course === null)
        {
            throw new CourseNotFoundException();
        }

        $course->setTitle($command->title);

        $course = CourseFactory::create(
            null,
            $command->title,
            $command->description,
            $command->startDate,
            $command->endDate
        );

        $this->courseRepository->save($course);

        return $course;

    }
}