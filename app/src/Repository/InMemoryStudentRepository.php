<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Student;
use App\Interfaces\StudentInterfaceRepository;

class InMemoryStudentRepository extends InMemoryAbstractRepository implements StudentInterfaceRepository
{
    /** @var Students[] */
    private array $students;

    /** @param Students[] $students */
    public function __construct(array $students = [])
    {
        $this->students = $students;
    }

    public function find($id)
    {
        foreach($this->students as $student)
        {
            if($student->getId() === $id){
                return $student;
            }
        }

        return null;
    }

    public function save(Student $student): void
    {
        $this->students[] = $student;
    }
}
