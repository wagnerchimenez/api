<?php 

declare(strict_types=1);

namespace App\Interfaces;

use App\Entity\User;

interface UserInterfaceRepository
{
    public function save(User $user) : void;
}