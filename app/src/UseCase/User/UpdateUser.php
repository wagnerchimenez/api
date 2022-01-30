<?php

declare(strict_types=1);

namespace App\UseCase\User;

class UpdateUser
{
    public int $userId;
    public string $name;
    public string $email;
    public string $password;
    public bool $status;

    public function __construct(
        int $userId,
        string $name,
        string $email,
        string $password,
        bool $status
    ) {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->status = $status;
    }
}
