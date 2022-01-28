<?php

namespace App\Entity;

use App\Repository\CourseRegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CourseRegistrationRepository::class)
 */
class CourseRegistration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\Date()
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course", inversedBy="CourseRegistrations")
     * @Assert\NotNull()
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="CourseRegistrations")
     * @Assert\NotNull()
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="CourseRegistrations")
     * @Assert\NotNull()
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCourseId(): ?int
    {
        return $this->course_id;
    }

    public function setCourseId(int $course_id): self
    {
        $this->course_id = $course_id;

        return $this;
    }

    public function getStudentId(): ?int
    {
        return $this->student_id;
    }

    public function setStudentId(int $student_id): self
    {
        $this->student_id = $student_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
