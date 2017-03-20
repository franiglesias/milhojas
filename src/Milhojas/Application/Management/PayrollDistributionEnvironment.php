<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 20/3/17
 * Time: 12:23
 */

namespace Milhojas\Application\Management;


/**
 * Encapsulates data of environment for a LaunchPayrollDistributor Command Handler
 *
 * Class PayrollDistributionEnvironment
 * @package Milhojas\Application\Management
 */
class PayrollDistributionEnvironment
{
    /**
     * @var string
     */
    private $environment;
    /**
     * @var string
     */
    private $logfile;
    /**
     * @var string
     */
    private $rootPath;

    /**
     * PayrollDistributionEnvironment constructor.
     *
     * @param $environment
     * @param $logfile
     * @param $rootPath
     */
    public function __construct($environment, $rootPath, $logfile)
    {
        $this->environment = $environment;
        $this->rootPath = $rootPath;
        $this->logfile = $logfile;
    }

    /**
     * @param \AppKernel $kernel
     * @param            $logfile
     *
     * @return PayrollDistributionEnvironment
     */
    public static function fromSymfonyKernel(\AppKernel $kernel, $logfile)
    {
        return new static($kernel->getEnvironment(), $kernel->getRootDir().'/../', $kernel->getLogDir().'/'.$logfile);
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return mixed
     */
    public function getLogfile()
    {
        return $this->logfile;
    }

    /**
     * @return mixed
     */
    public function getRootPath()
    {
        return $this->rootPath;
    }


}