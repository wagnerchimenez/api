<?php

declare(strict_types=1);

namespace App\UseCase\CourseRegistration;

use App\Entity\CourseRegistration;
use App\Exceptions\CourseRegistrationNotFoundException;
use App\Interfaces\CourseRegistrationInterfaceRepository;

class DeleteCourseRegistrationHandler
{
    private CourseRegistrationInterfaceRepository $courseRegistrationRepository;

    public function __construct(
        CourseRegistrationInterfaceRepository $courseRegistrationRepository
    ) {
        $this->courseRegistrationRepository = $courseRegistrationRepository;
    }

    public function handle(DeleteCourseRegistration $command): CourseRegistration
    {
        $courseRegistration = $this->courseRegistrationRepository->find($command->courseRegistrationId);

        if ($courseRegistration === null) {
            throw new CourseRegistrationNotFoundException();
        }

        return $courseRegistration;
    }
}
