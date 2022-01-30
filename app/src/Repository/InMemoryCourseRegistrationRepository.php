<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CourseRegistration;
use App\Interfaces\CourseRegistrationInterfaceRepository;
use DateTimeImmutable;

class InMemoryCourseRegistrationRepository extends InMemoryAbstractRepository implements CourseRegistrationInterfaceRepository
{
    /** @var CourseRegistration[] */
    private array $courseRegistrations;

    /** @param CourseRegistration[] $courseRegistrations */
    public function __construct(array $courseRegistrations = [])
    {
        $this->courseRegistrations = $courseRegistrations;
    }

    public function find($id)
    {
        foreach ($this->courseRegistrations as $courseRegistration) {
            if ($courseRegistration->getId() === $id) {
                return $courseRegistration;
            }
        }

        return null;
    }

    public function findAll()
    {
        return $this->courseRegistrations;
    }

    public function totalStudentsInCourse($courseId): int
    {
        $total = 0;

        foreach ($this->courseRegistrations as $courseRegistration) {
            if ($courseRegistration->getCourse()->getId() == $courseId) {
                $total++;
            }
        }

        return $total;
    }

    public function studentAlreadyRegisteredInCourse($studentId, $courseId): bool
    {
        foreach ($this->courseRegistrations as $courseRegistration) {
            if (
                $courseRegistration->getCourse()->getId() == $courseId &&
                $courseRegistration->getStudent()->getId() == $studentId
            ) {
                return true;
            }
        }

        return false;
    }

    public function save(CourseRegistration $courseRegistration): void
    {
        $this->courseRegistrations[] = $courseRegistration;
    }
}
