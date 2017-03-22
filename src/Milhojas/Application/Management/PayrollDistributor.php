<?php

namespace Milhojas\Application\Management;

use Milhojas\Infrastructure\Uploader\FileUploader;
use Symfony\Component\HttpFoundation\File\File;
use Milhojas\Domain\Management\PayrollMonth;


/**
 * Represents Distribution of Payroll for a month.
 */
class PayrollDistributor
{
    protected $month;
    protected $file;
    protected $fileName;

    /**
     * PayrollDistributor constructor.
     *
     * @param $month
     */
    public function __construct(PayrollMonth $month)
    {
        $this->setMonth($month);
    }


    public function setMonth(PayrollMonth $month)
    {
        $this->month = $month;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getYear()
    {
        return $this->month->getYear();
    }

    public function getMonthString()
    {
        return $this->month->getMonth();
    }

    public function setFile($files)
    {
        foreach ($files as $file) {
            if ($file instanceof File) {
                $this->file[] = $file;
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

    public function uploadFiles(FileUploader $uploader)
    {
        foreach ($this->file as $file) {
            $this->setFileName($uploader->upload($file));
        }
    }
}
