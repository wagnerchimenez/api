<?php 

declare(strict_types=1);

namespace App\UseCase;

use DateTimeImmutable;

class UpdateCourseRegistration{

    public int $courseRegistrationId;
    public int $courseId;
    public int $studentId;
    public int $userId;
    public DateTimeImmutable $date;

    public function __construct(
        int $courseRegistrationId,
        int $courseId,
        int $studentId,
        int $userId,
        DateTimeImmutable $date
    )
    {
        $this->courseRegistrationId = $courseRegistrationId;
        $this->courseId = $courseId;
        $this->studentId = $studentId;
        $this->userId = $userId;
        $this->date = $date;
    }
}