<?php 

declare(strict_types=1);

namespace App\Service;

use DateTimeImmutable;

class NewCourseRegistration{

    public int $courseId;
    public int $studentId;
    public int $userId;
    public DateTimeImmutable $date;

    public function __construct(
        int $courseId,
        int $studentId,
        int $userId,
        DateTimeImmutable $date
    )
    {
        $this->courseId = $courseId;
        $this->studentId = $studentId;
        $this->userId = $userId;
        $this->date = $date;
    }
}