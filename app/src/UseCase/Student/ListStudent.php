<?php 

declare(strict_types=1);

namespace App\UseCase\Student;

use DateTimeImmutable;

class ListStudent
{
    public ?int $studentId;
    public ?string $name;
    public ?string $email;
    public ?DateTimeImmutable $birthday;
    public ?bool $status;

    public function __construct(
        ?int $studentId = null,
        ?string $name = null,
        ?string $email = null,
        ?DateTimeImmutable $birthday = null,
        ?bool $status = null
    )
    {
        $this->studentId = $studentId;
        $this->name = $name;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->status = $status;
    }
}