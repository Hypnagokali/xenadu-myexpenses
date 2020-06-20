<?php
namespace Validation;

use Validation\ValidatorInterface;
use Validation\ValidationResponse;

class ExpensesValidator implements ValidatorInterface
{

    private $notEmpty = false;
    private $max = 0;
    private $min = 0;
    private $dateformat = false;
    private $number = false;

    private $locale = 'us';

    private function setRuleVars(array $rules)
    {
        $this->notEmpty = $rules['notEmpty'] ?? false;
        $this->max = $rules['max'] ?? 0;
        $this->min = $rules['min'] ?? 0;
        $this->dateformat = $rules['dateformat'] ?? false;
        $this->number = $rules['number'] ?? false;
        $this->locale = $rules['locale'] ?? 'us';
    }

    public function validate($data, array $rules)
    {
        $this->setRuleVars($rules);

        /* validate */
        $errorMessages = new ValidationResponse();
        if ($this->notEmpty) {
            if (!$this->notEmpty($data)) {
                $errorMessages->addError("Not Empty Error");
            }
        }

        if ($this->max > 0) {
            if (!$this->max($data)) {
                $errorMessages->addError("Maximum Length Error");
            }
        }

        if ($this->min > 0) {
            if (!$this->min($data)) {
                $errorMessages->addError("Minimum Length Error");
            }
        }

        if ($this->dateformat) {
            if (!$this->dateformat($data)) {
                $errorMessages->addError("Invalid Date Format Error");
            }
        }

        return $errorMessages;
    }

    private function notEmpty($data)
    {
        if (is_string($data) && $data === '') {
            return false;
        }
        if (is_numeric($data) && $data < 1) {
            return false;
        }
        if ($data === null) {
            return false;
        }

        return true;
    }

    private function max($data)
    {
        if (is_string($data) && strlen($data) > $this->max) {
            return false;
        }
        if (is_numeric($data) && $data > $this->max) {
            return false;
        }

        return true;
    }

    private function min($data)
    {
        if (is_string($data) && strlen($data) < $this->min) {
            return false;
        }
        if (is_numeric($data) && $data < $this->min) {
            return false;
        }
        return true;
    }

    private function dateformat($data)
    {
        if ($this->locale === 'us') {
            /* 9999-00-99 ist so möglich. Nachbessern! */
            if (!preg_match('#^[1|2][0-9]{3}-([0][1-9]|[1][0-2])-([0][1-9]|[1|2][0-9]|[3][0-1])#', $data)) {
                return false;
            }
            return true;
        } elseif ($this->locale === 'de') {
            if (!preg_match('#^([0][1-9]|[1|2][0-9]|[3][0-1]).([0][1-9]|[1][0-2]).[1|2][0-9]{3}#', $data)) {
                return false;
            }
            return true;
        }
        
    }

    public function prepareData($data)
    {
        $trimed = trim($data);
        $stripped = strip_tags($trimed);
        $finalData = htmlspecialchars($stripped);
        return $finalData;
    }
}