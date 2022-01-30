<?php

declare(strict_types=1);

namespace App\UseCase\Student;

use DateTimeImmutable;

class NewStudent
{
    public ?int $studentId;
    public string $name;
    public string $email;
    public DateTimeImmutable $birthDate;
    public bool $status;

    public function __construct(
        ?int $studentId,
        string $name,
        string $email,
        DateTimeImmutable $birthDate,
        bool $status
    ) {
        $this->studentId = $studentId;
        $this->name = $name;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->status = $status;
    }
}
