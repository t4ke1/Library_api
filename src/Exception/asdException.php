<?php

declare(strict_types=1);

namespace App\Exception;

class asdException extends \Exception implements CustomExceptionInterface
{
    public function __construct(string $message = 'asd', int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
