<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('wagnerllchimenez.comp@gmail.com')
            ->setPassword('$2y$13$E0eI7f1RuiXyrfuUwlWX1embB9rB2R81zEbWufl6zZJ0PSMYNSsQK');

        $manager->persist($user);
        $manager->flush();
    }
}
