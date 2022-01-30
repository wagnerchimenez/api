<?php

declare(strict_types=1);

namespace App\UseCase\User;

class DeleteUser
{
    public int $userId;

    public function __construct(
        int $userId,
    ) {
        $this->userId = $userId;
    }
}
