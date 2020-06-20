<?php
namespace Validation;

class ValidationResponse
{
    private $errorMessages;

    public function __construct(array $errorMessages = [])
    {
        $this->errorMessages = $errorMessages;
    }

    public function addError(string $errorMessage)
    {
        $this->errorMessages []= $errorMessage;
    }

    public function hasErrorMessages()
    {
        if (count($this->errorMessages) > 0) {
            return true;
        }
        return false;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
