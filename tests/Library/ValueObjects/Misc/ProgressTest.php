<?php

namespace Tests\Library\ValueObjects\Misc;

use Milhojas\Library\ValueObjects\Misc\Progress;

class ProgressTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_can_create_a_progress_object()
	{
		$progress = new Progress(1, 10);
		$this->assertEquals(' 1 / 10', $progress->__toString());
		$this->assertEquals(1, $progress->getCurrent());
		$this->assertEquals(10, $progress->getTotal());
	}
	/**
	 * @expectedException OutOfBoundsException
	 */
	public function test_it_fails_if_current_is_greater_than_total()
	{
		$progress = new Progress(20, 10);
	}
	
	public function test_it_can_advance_returning_a_new_object()
	{
		$progress = new Progress(0, 10);
		$this->assertEquals(0, $progress->getCurrent());
		$progress = $progress->advance();
		$this->assertEquals(1, $progress->getCurrent());
		$progress = $progress->advance();
		$this->assertEquals(2, $progress->getCurrent());
	}
	
	/**
	 * @expectedException OutOfBoundsException
	 */
	public function test_it_can_not_advance_pass_limits()
	{
		$progress = new Progress(9, 10);
		$progress = $progress->advance();
		$this->assertEquals(10, $progress->getCurrent());
		$progress = $progress->advance();
	}
}


?>