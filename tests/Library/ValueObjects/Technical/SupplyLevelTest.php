<?php

namespace Tests\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\SupplyLevel;
/**
* Description
*/
class SupplyLevelTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_admits_values_from_0_to_5()
	{
		$level = new SupplyLevel(1);
		$this->assertEquals(1, $level->getLevel());
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_exception_for_invalid_values()
	{
		$level = new SupplyLevel(7);
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function test_exception_for_invalid_negative_values()
	{
		$level = new SupplyLevel(-1);
	}
	
	public function test_0_or_1_are_should_replace_values()
	{
		$level = new SupplyLevel(0);
		$this->assertTrue($level->shouldReplace());
	}
	
	public function test_returns_a_text_graph()
	{
		$level = new SupplyLevel(3);
		$this->assertEquals('[###  ]', $level->getGraph());
		
		$level = new SupplyLevel(5);
		$this->assertEquals('[#####]', $level->getGraph());

		$level = new SupplyLevel(0);
		$this->assertEquals('[     ]', $level->getGraph());
	}
	
	public function test_it_returns_verbose_level()
	{
		$levels = array(
			'exhausted',
			'almost empty',
			'low',
			'medium',
			'high',
			'almost full'
		);
		foreach ($levels as $level => $expected) {
			$testedLevel = new SupplyLevel($level);
			$this->assertEquals($expected, $testedLevel->verbose());
		}
	}
}
?>
