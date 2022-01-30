<?php

declare(strict_types=1);

namespace App\UseCase\Student;

use App\Entity\Student;
use App\Exceptions\StudentNotFoundException;
use App\Interfaces\StudentInterfaceRepository;

class DeleteStudentHandler
{
    private StudentInterfaceRepository $studentRepository;

    public function __construct(
        StudentInterfaceRepository $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
    }

    public function handle(DeleteStudent $command): Student
    {
        $student = $this->studentRepository->find($command->studentId);

        if ($student === null) {
            throw new StudentNotFoundException();
        }

        return $student;
    }
}
