<?php

declare(strict_types=1);

namespace App\UseCase\Student;

use App\Entity\Student;
use App\Exceptions\StudentNotFoundException;
use App\Interfaces\StudentInterfaceRepository;

class ListStudentHandler
{
    private StudentInterfaceRepository $studentRepository;

    public function __construct(
        StudentInterfaceRepository $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
    }

    /** @return Student[] */
    public function handle(ListStudent $command): array
    {
        if ($command->studentId === null) {
            return $this->studentRepository->findAll();
        }

        $student = $this->studentRepository->find($command->studentId);

        if ($student === null) {
            throw new StudentNotFoundException();
        }

        return [$student];
    }
}
