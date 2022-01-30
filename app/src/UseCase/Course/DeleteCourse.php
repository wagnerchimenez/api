<?php

declare(strict_types=1);

namespace App\UseCase\Course;

class DeleteCourse
{
    public int $courseId;

    public function __construct(
        int $courseId,
    ) {
        $this->courseId = $courseId;
    }
}
