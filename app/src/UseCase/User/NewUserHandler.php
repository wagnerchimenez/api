<?php

declare(strict_types=1);

namespace App\UseCase\User;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Interfaces\UserInterfaceRepository;

class NewUserHandler
{
    private UserInterfaceRepository $userRepository;

    public function __construct(
        UserInterfaceRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(NewUser $command): User
    {
        $user = UserFactory::create(
            null,
            $command->name,
            $command->email,
            $command->password,
            $command->status,
        );

        $this->userRepository->save($user);

        return $user;
    }
}
