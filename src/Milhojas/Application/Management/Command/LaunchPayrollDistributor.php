<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 20/3/17
 * Time: 10:20
 */

namespace Milhojas\Application\Management\Command;

use Milhojas\Application\Management\PayrollDistributionEnvironment;
use Milhojas\Application\Management\PayrollDistributor;
use Milhojas\Messaging\CommandBus\Command;


class LaunchPayrollDistributor implements Command
{
    /**
     * @var PayrollDistributor
     */
    private $distribution;
    /**
     * @var PayrollDistributionEnvironment
     */
    private $environment;


    /**
     * LaunchPayrollDistributor constructor.
     *
     * @param PayrollDistributor $distribution
     * @param string             $environment
     * @param string             $rootPath
     * @param string             $logfile
     */
    public function __construct(PayrollDistributor $distribution, PayrollDistributionEnvironment $environment)
    {
        $this->distribution = $distribution;
        $this->environment = $environment;
    }


    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment->getEnvironment();
    }


    /**
     * @return PayrollDistributor
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    public function getMonth()
    {
        return $this->distribution->getMonthString();
    }

    public function getYear()
    {
        return $this->distribution->getYear();
    }

    public function getFileName()
    {
        return $this->distribution->getFileName();
    }
    /**
     * @return string
     */
    public function getRootPath()
    {
        return $this->environment->getRootPath();
    }

    /**
     * @return string
     */
    public function getLogfile()
    {
        return $this->environment->getLogfile();
    }


}
