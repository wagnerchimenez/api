<?php 

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Course;
use App\Entity\Student;
use DateTimeImmutable;
use Exception;

class StudentFactory{

    private string $name;
    private string $email;
    private DateTimeImmutable $birthday;
    private bool $status;

    private function __construct(
        string $name,
        string $email,
        DateTimeImmutable $birthday,
        bool $status
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->status = $status;
    }

    public static function create(
        string $name,
        string $email,
        DateTimeImmutable $birthday,
        bool $status
    ) : Student{

        $today = DateTimeImmutable::createFromFormat('Y-m-d', date('Y-m-d'));
        $age = $birthday->diff($today)->y;

        if($age < 16){
            throw new Exception('Sorry, under 16!');
        }

        $student = new Student();
        $student->setName($name);
        $student->setEmail($email);
        $student->setBirthday($birthday);
        $student->setStatus($status);

        return $student;
    }
}