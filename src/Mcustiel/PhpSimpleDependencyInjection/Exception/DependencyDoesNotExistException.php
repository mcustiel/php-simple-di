<?php
namespace Mcustiel\PhpSimpleDependencyInjection\Exception;

class DependencyDoesNotExistException extends \Exception
{
    const DEFAULT_CODE = 1;

    public function __construct($message, \Exception $previous = null)
    {
        // TODO Auto-generated method stub
        parent::__construct($message, self::DEFAULT_CODE, $previous);
    }
}