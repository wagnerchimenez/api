<?php

declare(strict_types=1);

namespace App\UseCase\CourseRegistration;

use DateTimeImmutable;

class ListCourseRegistration
{
    public ?int $courseRegistrationId;
    public ?int $courseId;
    public ?int $studentId;
    public ?int $userId;
    public ?DateTimeImmutable $date;

    public function __construct(
        ?int $courseRegistrationId = null,
        ?int $courseId = null,
        ?int $studentId = null,
        ?int $userId = null,
        ?DateTimeImmutable $date = null
    ) {
        $this->courseRegistrationId = $courseRegistrationId;
        $this->courseId = $courseId;
        $this->studentId = $studentId;
        $this->userId = $userId;
        $this->date = $date;
    }
}
