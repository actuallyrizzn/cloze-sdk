<?php

namespace Cloze\SDK\Exceptions;

/**
 * Base exception for all Cloze API errors.
 */
class ClozeAPIError extends \Exception
{
    protected $errorcode;
    protected $response;

    public function __construct(string $message, ?int $errorcode = null, $response = null)
    {
        parent::__construct($message);
        $this->errorcode = $errorcode;
        $this->response = $response;
    }

    public function getErrorcode(): ?int
    {
        return $this->errorcode;
    }

    public function getResponse()
    {
        return $this->response;
    }
}

