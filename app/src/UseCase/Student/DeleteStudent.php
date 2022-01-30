<?php

declare(strict_types=1);

namespace App\UseCase\Student;

class DeleteStudent
{
    public int $studentId;

    public function __construct(
        int $studentId,
    ) {
        $this->studentId = $studentId;
    }
}
