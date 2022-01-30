<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CourseInProgressOrClosedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Course in progress or closed!');
    }
}
