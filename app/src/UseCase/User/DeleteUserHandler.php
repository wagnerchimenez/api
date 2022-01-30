<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Entity\User;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\UserInterfaceRepository;

class DeleteUserHandler
{
    private UserInterfaceRepository $userRepository;

    public function __construct(
        UserInterfaceRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(DeleteUser $command): User
    {
        $user = $this->userRepository->find($command->userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
