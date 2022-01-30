<?php 

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\Student;

interface StudentInterfaceRepository
{
    public function save(Student $course) : void;
}