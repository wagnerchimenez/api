<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class StudentNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Student not found!');
    }
}
