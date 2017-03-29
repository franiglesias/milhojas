<?php
/**
 * Created by PhpStorm.
 * User: Fran Iglesias <franiglesias@mac.com>
 * Date: 29/3/17
 * Time: 13:28
 */

namespace Tests\Application\Management\Command;

use Milhojas\Application\Management\Command\StartPayroll;
use Milhojas\Domain\Management\PayrollReporter;
use PHPUnit\Framework\TestCase;


class StartPayrollTest extends TestCase
{

    public function test_it_transports_the_needed_information()
    {

        $progress = new PayrollReporter(1, 100);
        $command = new StartPayroll($progress);
        $this->assertEquals($progress, $command->getProgress());
    }
}
