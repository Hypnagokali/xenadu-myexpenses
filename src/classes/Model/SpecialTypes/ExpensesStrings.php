<?php
namespace Model\SpecialTypes;

use DateTime;
use DateTimeImmutable;
use Model\Expenses;

class ExpensesStrings
{
    private $expenses;

    public function __construct(Expenses $expenses)
    {
        $this->expenses = $expenses;
    }

    public function getSumEuroString() : string
    {
        $euro = $this->expenses->getSum();
        return self::convertToEuroString($euro);
    }

    public function getOccurredAtAsString(string $format = 'd.m') : string
    {
        $occurredAt = self::convertToDateTime($this->expenses->getOccurredAt());
        return $occurredAt->format($format);
    }

    public static function convertToEuroString($sum) : string
    {
        $euro = $sum / 100;
        $sumString = sprintf('%05.2f €', $euro);
        $euro_string = str_replace('.', ',', $sumString);
        return $euro_string;
    }

    public static function convertToDateTime(string $date) : DateTimeImmutable
    {
        $dateTime = new DateTimeImmutable($date);
        return $dateTime;
    }
}