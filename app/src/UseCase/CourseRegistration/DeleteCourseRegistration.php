<?php

declare(strict_types=1);

namespace App\UseCase\CourseRegistration;

class DeleteCourseRegistration
{
    public int $courseRegistrationId;

    public function __construct(
        int $courseRegistrationId,
    ) {
        $this->courseRegistrationId = $courseRegistrationId;
    }
}
