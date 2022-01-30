<?php 

declare(strict_types=1);

namespace App\UseCase\User;

use DateTimeImmutable;

class ListUser
{
    public ?int $userId;
    public ?string $name;
    public ?string $email;
    public ?bool $status;

    public function __construct(
        ?int $userId = null,
        ?string $name = null,
        ?string $email = null,
        ?bool $status = null
    )
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
    }
}