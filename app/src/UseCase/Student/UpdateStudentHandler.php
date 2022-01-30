<?php

declare(strict_types=1);

namespace App\UseCase\Student;

use App\Entity\Student;
use App\Exceptions\StudentNotFoundException;
use App\Interfaces\StudentInterfaceRepository;

class UpdateStudentHandler
{
    private StudentInterfaceRepository $studentRepository;

    public function __construct(
        StudentInterfaceRepository $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
    }

    public function handle(UpdateStudent $command): Student
    {
        $student = $this->studentRepository->find($command->studentId);

        if ($student === null) {
            throw new StudentNotFoundException();
        }

        $student->setName($command->name);
        $student->setEmail($command->email);
        $student->setBirthday($command->birthday);
        $student->setStatus($command->status);

        return $student;
    }
}
