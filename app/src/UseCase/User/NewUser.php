<?php 

declare(strict_types=1);

namespace App\UseCase\User;

class NewUser
{
    public string $name;
    public string $email;
    public string $password;
    public bool $status;

    public function __construct(
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
}