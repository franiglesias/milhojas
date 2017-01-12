<?php

namespace Milhojas\Application\Management;

use Symfony\Component\HttpFoundation\File\File;
use Milhojas\Domain\Management\PayrollMonth;

/**
 * Represents Distribution of Payroll for a month.
 */
class PayrollDistributor
{
    protected $month;
    protected $year;
    protected $file;
    protected $fileName;

    public function setMonth(PayrollMonth $month)
    {
        $this->month = $month;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setFile($files)
    {
        foreach ($files as $file) {
            if ($file instanceof File) {
                $this->file = $files;
            }
        }
        if ($files) {
            $this->completed = new \DateTime('now');
        }

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFileName($fileName)
    {
        $this->fileName[] = $fileName;

        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
