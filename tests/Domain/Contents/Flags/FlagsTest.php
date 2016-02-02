<?php

namespace Milhojas\Tests\Domain\Contents\Flags;

use \Milhojas\Domain\Contents\Flags as Flag;

/**
* Description
*/
class FlagsTest extends \PHPUnit_Framework_Testcase
{
	public function test_flags()
	{
		$store = new Flag\FlagCollection(new \SplObjectStorage());
		$factory = new Flag\FlagFactory();
		$store->add($factory->get('Featured'));
		$this->assertEquals(1, $store->count());
		$this->assertTrue($store->has($factory->get('Featured')));
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_factory()
	{
		$factory = new Flag\FlagFactory();
		$factory->get('Invented');
	}
}

?>