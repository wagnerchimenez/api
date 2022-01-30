<?php 

declare(strict_types=1);

namespace App\UseCase\Course;

use DateTimeImmutable;

class ListCourse
{
    public ?int $courseId;
    public ?string $title;
    public ?string $description;
    public ?DateTimeImmutable $startDate;
    public ?DateTimeImmutable $endDate;

    public function __construct(
        ?int $courseId = null,
        ?string $title = null,
        ?string $description = null,
        ?DateTimeImmutable $startDate = null,
        ?DateTimeImmutable $endDate = null
    )
    {
        $this->courseId = $courseId;
        $this->title = $title;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}