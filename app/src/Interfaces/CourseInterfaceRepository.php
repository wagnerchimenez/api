<?php 

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\Course;

interface CourseInterfaceRepository
{
    public function save(Course $course) : void;
}