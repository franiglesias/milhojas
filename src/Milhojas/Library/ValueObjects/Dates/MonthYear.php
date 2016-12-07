<?php

namespace Milhojas\Library\ValueObjects\Dates;

class MonthYear
{
    private $month;
    private $year;

    private function __construct(\DateTime $date)
    {
        $this->month = $date->format('m');
        $this->year = $date->format('Y');
    }

    public static function create($month, $year)
    {
        $format = '%s/1/%s';
        if (!is_numeric($month)) {
            $format = '1st %s %s';
        }
        $date = new \DateTime(sprintf($format, $month, $year));

        return new self($date);
    }

    public static function fromDate(\DateTime $date)
    {
        return new self($date);
    }

    public static function current()
    {
        return new self(new \DateTime());
    }

    public function asString()
    {
        return sprintf('%s/%s', $this->month, $this->year);
    }

    public function __toString()
    {
        return sprintf('%s/%s', $this->month, $this->year);
    }
}
