<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 0; $i < 30; $i++){

            $user = UserFactory::create(
                null,
                'Username ' . $i,
                'user_email_' . $i . '@gmail.com',
                '123456',
                true
            );

            $user->setPassword($this->hasher->hashPassword($user, '123456'));
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
