<?php

namespace App\DataFixtures;

use App\Entity\Student;
use App\Factory\StudentFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 30; $i++) {

            $student = StudentFactory::create(
                'Student name ' . $i,
                'student_email_' . $i . '@gmail.com',
                DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
                true
            );

            $manager->persist($student);
        }

        $manager->flush();
    }
}
