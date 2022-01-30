<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User;

class UserFactory
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $status;

    private function __construct(
        ?int $id,
        string $name,
        string $email,
        string $password,
        bool $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
    }

    public static function create(
        ?int $id,
        string $name,
        string $email,
        string $password,
        bool $status
    ): User {

        $user = new User();
        $user->setId($id);
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setStatus($status);

        return $user;
    }
}
