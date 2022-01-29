<?php 

declare(strict_types=1);

namespace App\UseCase\Course;

use DateTimeImmutable;

class UpdateCourse
{
    public int $courseId;
    public string $title;
    public string $description;
    public DateTimeImmutable $startDate;
    public DateTimeImmutable $endDate;

    public function __construct(
        int $courseId,
        string $title,
        string $description,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    )
    {
        $this->courseId = $courseId;
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}