<?php

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\PayrollMonth;
use PHPUnit\Framework\TestCase;


/**
 * Description.
 */
class PayrollMonthTest extends TestCase
{
    public function test_it_constructs()
    {
        $month = new PayrollMonth('01', '2017');
        $this->assertEquals('01', $month->getMonth());
        $this->assertEquals('2017', $month->getYear());
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

    public function test_folder_name_should_have_YYYY_slash_MM_format()
    {
        $month = new PayrollMonth('01', '2017');
        $this->assertEquals('2017/01', $month);
    }

    public function test_can_be_created_with_named_constructor_for_current_month()
    {
        $month = PayrollMonth::current();
        $this->assertEquals(date('Y/m'), $month->getFolderName());
    }

    public function test_get_previous_month()
    {
        $month = new PayrollMonth('03', '2017');
        $this->assertEquals(new PayrollMonth('02', '2017'), $month->getPrevious());
    }

    public function test_get_previous_month_change_year()
    {
        $month = new PayrollMonth('01', '2017');
        $this->assertEquals(new PayrollMonth('12', '2016'), $month->getPrevious());
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_valid_years_start_at_previous_to_current()
    {
        $month = new PayrollMonth('01', '2015');
    }


}
