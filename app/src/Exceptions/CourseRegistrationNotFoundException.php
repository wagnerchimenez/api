<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CourseRegistrationNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Course Registration not found!');
    }
}
