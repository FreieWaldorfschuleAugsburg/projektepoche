<?php


namespace App\Exceptions;
use Exception;
use Throwable;

class HasNoProjectsException extends Exception
{

    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(lang('user.leader.error.noProjects'), $code, $previous);
    }


}