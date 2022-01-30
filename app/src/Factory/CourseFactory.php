<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Course;
use DateTimeImmutable;

class CourseFactory
{
    private ?int $id;
    private string $title;
    private string $desctiption;
    private DateTimeImmutable $startDate;
    private DateTimeImmutable $endDate;

    private function __construct(
        ?int $id,
        string $title,
        string $desctiption,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->desctiption = $desctiption;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public static function create(
        ?int $id,
        string $title,
        string $desctiption,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate
    ): Course {

        $course = new Course();
        $course->setId($id);
        $course->setTitle($title);
        $course->setDescription($desctiption);
        $course->setStartDate($startDate);
        $course->setEndDate($endDate);

        return $course;
    }
}
