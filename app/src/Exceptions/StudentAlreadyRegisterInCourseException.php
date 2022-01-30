<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class StudentAlreadyRegisterInCourseException extends Exception
{
    public function __construct()
    {
        parent::__construct('Student Already Register in course!');
    }
}
