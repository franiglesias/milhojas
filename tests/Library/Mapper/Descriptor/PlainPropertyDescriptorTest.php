<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\PlainPropertyDescriptor;

include_once('TestClasses.php');

class PlainPropertyDescriptorTest extends AbstractPropertyDescriptorTest {
	
	public function test_it_describes_plain_property()
	{
		$pd = new PlainPropertyDescriptor($this->getProperty('id'), $this->getClass());
		$this->assertEquals(array('id' => 1), $pd->describe());
	}
	
	public function test_it_describes_plain_property_2_with_prefix()
	{
		$pd = new PlainPropertyDescriptor($this->getProperty('id'), $this->getClass());
		$this->assertEquals(array('prefix.id' => 1), $pd->describe('prefix'));
	}
	
}

?>