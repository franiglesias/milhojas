<?php

namespace Milhojas\Domain\Management;

/**
 * Represents the month of a payroll.
 */
class PayrollMonth
{
    private $month;
    private $year;

    public function __construct($month, $year)
    {
        $this->isValidMonth($month);
        $this->isValidYear($year);
        $this->month = $month;
        $this->year = $year;
    }

    public static function current()
    {
        return new static(date('m'), date('Y'));
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getFolderName()
    {
        return sprintf('%s/%s', $this->year, $this->month);
    }

    public function __toString()
    {
        return $this->getFolderName();
    }

    private function isValidMonth($month)
    {
        if (!is_numeric($month) || ($month > 12 || $month < 1)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid month.', $month));
        }
    }

    private function isValidYear($year)
    {
        $current = (new \DateTime())->format('Y');
        if ($current - 1 > $year) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid year.', $year));
        }
    }
}
