<?php


namespace Milhojas\Tests\Library\ValueObjects\Dates;

use Library\ValueObjects\Dates\DateRange;

/**
* Description
*/
class DateRangeTest extends \PHPUnit_Framework_Testcase
{
	# Basic usage
	
	public function test_it_returns_true_if_date_is_in_the_interval_including_limits()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+5 day'));
		$this->assertTrue($Pub->includes(new \DateTimeImmutable()));
		$this->assertTrue($Pub->includes(new \DateTimeImmutable('+1 day')));
		$this->assertTrue($Pub->includes(new \DateTimeImmutable('+5 day')));
	}
	
	public function test_it_returns_false_if_date_is_far_from_expiration_date()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+5 day'));
		$this->assertFalse($Pub->includes(new \DateTimeImmutable('+10 day')));
	}
	
	public function test_it_returns_false_if_date_is_before_start_date()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+5 day'));
		$this->assertFalse($Pub->includes(new \DateTimeImmutable('-10 day')));
	}
	
	public function test_it_returns_true_if_date_is_greater_than_start_date_on_open_range()
	{
		$Pub = new DateRange(new \DateTimeImmutable());
		$this->assertTrue($Pub->includes(new \DateTimeImmutable('+2 day')));
	}
	
	# Creation ofvalid objects
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function test_can_not_instantiate_object_with_no_start_date()
	{
		$PubDate = new DateRange(null);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function test_can_not_instantiate_object_with_no_start_date_but_end_date()
	{
		$PubDate = new DateRange(null, new \DateTimeImmutable());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_can_not_instantiate_object_with_end_date_equal_to_start_date()
	{
		$PubDate = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable());
	}
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_can_not_instantiate_object_with_end_date_before_start_date()
	{
		$PubDate = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('-5 day'));
	}

	# Changing range limits
	
	public function test_change_expiration_returns_object()
	{
		$Pub = new DateRange(new \DateTimeImmutable());
		$NewPub = $Pub->changeExpiration(new \DateTimeImmutable('+ 5 day'));
		$this->assertInstanceOf('\Library\ValueObjects\Dates\DateRange', $NewPub);

		$Expected = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+ 5 day'));
		$this->assertEquals($Expected, $NewPub);
	}
	
	public function test_can_change_expiration_to_null_value()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+2 day'));
		$NewPub = $Pub->changeExpiration();
		$this->assertInstanceOf('\Library\ValueObjects\Dates\DateRange', $NewPub);

		$Expected = new DateRange(new \DateTimeImmutable());
		$this->assertEquals($Expected, $NewPub);
	}
	
	public function test_change_start_returns_object()
	{
		$Pub = new DateRange(new \DateTimeImmutable());
		$NewPub = $Pub->changeStart(new \DateTimeImmutable('+ 5 day'));
		$this->assertInstanceOf('\Library\ValueObjects\Dates\DateRange', $NewPub);

		$Expected = new DateRange(new \DateTimeImmutable('+ 5 day'));
		$this->assertEquals($Expected, $NewPub);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_change_start_does_not_allow_start_greater_than_end()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+5 day'));
		$NewPub = $Pub->changeStart(new \DateTimeImmutable('+10	 day'));
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Exception
	 */
	public function test_change_start_does_not_allow_null_date()
	{
		$Pub = new DateRange(new \DateTimeImmutable(), new \DateTimeImmutable('+5 day'));
		$NewPub = $Pub->changeStart(null);
	}
	
}
?>