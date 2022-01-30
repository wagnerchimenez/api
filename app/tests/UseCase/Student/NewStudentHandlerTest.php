<?php

declare(strict_types=1);

namespace Tests\UseCase\Student;

use App\Entity\Student;
use App\Exceptions\StudentUnder16Exception;
use App\Repository\InMemoryStudentRepository;
use App\UseCase\Student\NewStudent;
use App\UseCase\Student\NewStudentHandler;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewStudentHandlerTest extends TestCase
{
    public function testShouldAddNewStudent(): void
    {
        $studentRepository = new InMemoryStudentRepository();

        $command = new NewStudent(
            10,
            'name',
            'email',
            DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
            true
        );

        $handler = new NewStudentHandler(
            $studentRepository
        );

        $student = $handler->handle($command);

        $this->assertInstanceOf(Student::class, $student);
        $this->assertNotEmpty($studentRepository->findAll());
    }

    public function testShouldNotAcceptStudentUnder16(): void
    {
        $this->expectException(StudentUnder16Exception::class);

        $studentRepository = new InMemoryStudentRepository();

        $command = new NewStudent(
            10,
            'name',
            'email',
            DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d')),
            true
        );

        $handler = new NewStudentHandler(
            $studentRepository
        );
        
        $handler->handle($command);
    }
}
