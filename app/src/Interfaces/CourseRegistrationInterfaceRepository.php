<?php 

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\CourseRegistration;

interface CourseRegistrationInterfaceRepository
{
    public function totalStudentsInCourse($courseId): int;
    public function courseInProgressOrClosed($courseId, $date): bool;
    public function studentAlreadyRegisteredInCourse($studentId, $courseId): bool;
    //public function save(CourseRegistration $courseRegistration): void;
}