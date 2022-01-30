<?php

declare(strict_types=1);

namespace App\UseCase\Student;

use App\Entity\Student;
use App\Exceptions\StudentUnder16Exception;
use App\Factory\StudentFactory;
use App\Interfaces\StudentInterfaceRepository;
use DateTimeImmutable;

class NewStudentHandler
{
    private StudentInterfaceRepository $studentRepository;

    public function __construct(
        StudentInterfaceRepository $studentRepository
    ) {
        $this->studentRepository = $studentRepository;
    }

    public function handle(NewStudent $command): Student
    {
        $today = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $under16 = $command->birthDate->diff($today)->y < 16 ? true : false;

        if($under16){
            throw new StudentUnder16Exception();
        }

        $student = StudentFactory::create(
            $command->studentId,
            $command->name,
            $command->email,
            $command->birthDate,
            $command->status
        );

        $this->studentRepository->save($student);

        return $student;
    }
}
