<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Entity\User;
use App\Exceptions\UserNotFoundException;
use App\Interfaces\UserInterfaceRepository;

class ListUserHandler
{
    private UserInterfaceRepository $userRepository;

    public function __construct(
        UserInterfaceRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /** @return User[] */
    public function handle(ListUser $command): array
    {
        if ($command->userId === null) {
            return $this->userRepository->findAll();
        }

        $user = $this->userRepository->find($command->userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return [$user];
    }
}
