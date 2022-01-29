<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Factory\CourseFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\ByteString;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 30; $i++) {

            $course = CourseFactory::create(
                'Course ' . $i,
                'Description of course',
                DateTimeImmutable::createFromFormat('Y-m-d', '2022-03-01'),
                DateTimeImmutable::createFromFormat('Y-m-d', '2022-06-01')
            );

            $manager->persist($course);
        }

        $manager->flush();
    }
}
