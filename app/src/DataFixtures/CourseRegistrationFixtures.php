<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\CourseRegistration;
use App\Factory\CourseFactory;
use App\Factory\CourseRegistrationFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseRegistrationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $courseSymfony = CourseFactory::create(
            null,
            'Symfony',
            'Symfony Api',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-03-01'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-06-01')
        );

        $manager->persist($courseSymfony);

        $courseDocker = CourseFactory::create(
            null,
            'Docker',
            'Fast course of Docker',
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-02-03'),
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-04-01')
        );

        $manager->persist($courseDocker);

        $student = StudentFactory::create(
            'Wagner Lima Chimenez',
            'wagnerllchimenez.comp@gmail.com',
            DateTimeImmutable::createFromFormat('Y-m-d', '1988-08-05'),
            true
        );

        $manager->persist($student);

        $user = UserFactory::create(
            'Name of user admin',
            'useremail@gmail.com',
            '123456',
            true
        );

        $manager->persist($user);

        $courseRegistration1 = CourseRegistrationFactory::create(
            $courseSymfony,
            $student,
            $user,
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01')
        );

        $manager->persist($courseRegistration1);

        $courseRegistration2 = CourseRegistrationFactory::create(
            $courseDocker,
            $student,
            $user,
            DateTimeImmutable::createFromFormat('Y-m-d', '2022-01-01')
        );

        $manager->persist($courseRegistration2);
        
        $manager->flush();
        
    }
}
