<?php 

declare(strict_types=1);

namespace App\UseCase\Course;

use DateTimeImmutable;

class NewCourse
{
    public string $title;
    public string $description;
    public DateTimeImmutable $startDate;
    public DateTimeImmutable $endDate;

    public function __construct(
        string $title,
        string $description,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}