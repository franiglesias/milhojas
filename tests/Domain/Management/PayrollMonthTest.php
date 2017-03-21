<?php

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\PayrollMonth;

/**
 * Description.
 */
class PayrollMonthTest extends \PHPUnit_Framework_Testcase
{
    public function test_it_constructs()
    {
        $month = new PayrollMonth('01', '2017');
        $this->assertEquals('2017/01', $month);
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @author Fran Iglesias
     */
    public function test_month_should_be_valid_month()
    {
        $month = new PayrollMonth('yakasi', '2017');
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @author Fran Iglesias
     */
    public function test_year_should_be_a_valid_year()
    {
        $month = new PayrollMonth('enero', '1915');
    }
}
