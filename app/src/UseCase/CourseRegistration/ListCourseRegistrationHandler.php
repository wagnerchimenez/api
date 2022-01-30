<?php

declare(strict_types=1);

namespace App\UseCase\CourseRegistration;

use App\Entity\CourseRegistration;
use App\Exceptions\CourseRegistrationNotFoundException;
use App\Interfaces\CourseRegistrationInterfaceRepository;

class ListCourseRegistrationHandler
{
    private CourseRegistrationInterfaceRepository $courseRegistrationRepository;

    public function __construct(
        CourseRegistrationInterfaceRepository $courseRegistrationRepository
    ) {
        $this->courseRegistrationRepository = $courseRegistrationRepository;
    }

    /** @return CourseRegistration[] */
    public function handle(ListCourseRegistration $command): array
    {
        if ($command->courseRegistrationId === null) {
            return $this->courseRegistrationRepository->findAll();
        }

        $courseRegistration = $this->courseRegistrationRepository->find($command->courseRegistrationId);

        if ($courseRegistration === null) {
            throw new CourseRegistrationNotFoundException();
        }

        return [$courseRegistration];
    }
}
