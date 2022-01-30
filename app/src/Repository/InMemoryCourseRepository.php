<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Course;
use App\Interfaces\CourseInterfaceRepository;

class InMemoryCourseRepository extends InMemoryAbstractRepository implements CourseInterfaceRepository
{
    /** @var Course[] */
    private array $courses;

    /** @param Course[] $courses */
    public function __construct(array $courses = [])
    {
        $this->courses = $courses;
    }

    public function find($id)
    {
        foreach($this->courses as $course)
        {
            if($course->getId() === $id){
                return $course;
            }
        }

        return null;
    }

    public function findAll()
    {
        return $this->courses;
    }

    public function save(Course $course): void
    {
        $this->courses[] = $course;
    }
}
