<?php 

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;

class UserFactory{

    private string $name;
    private string $email;
    private string $password;
    private bool $status;
    
    private function __construct(
        string $name,
        string $email,
        string $password,
        bool $status
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
    }

    public static function create(
        string $name,
        string $email,
        string $password,
        bool $status
    ) : User{

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setStatus($status);

        return $user;
    }
}