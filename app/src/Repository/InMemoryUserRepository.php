<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Interfaces\UserInterfaceRepository;

class InMemoryUserRepository extends InMemoryAbstractRepository implements UserInterfaceRepository
{
    /** @var User[] */
    private array $users;

    /** @param User[] $users */
    public function __construct(array $users = [])
    {
        $this->users = $users;
    }

    public function find($id)
    {
        foreach($this->users as $user)
        {
            if($user->getId() === $id){
                return $user;
            }
        }

        return null;
    }
    
}
