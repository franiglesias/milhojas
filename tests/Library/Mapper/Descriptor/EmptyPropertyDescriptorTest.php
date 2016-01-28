<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\EmptyPropertyDescriptor;

include_once('TestClasses.php');

class EmptyPropertyDescriptorTest extends AbstractPropertyDescriptorTest {
		
	public function test_it_describes_empty_property_as_class_name()
	{
		$pd = new EmptyPropertyDescriptor($this->getProperty('empty'), $this->getClass());
		$this->assertEquals(array('empty' => 'EmptyClass'), $pd->describe());
	}
	
	public function test_it_describes_empty_property_as_class_name_with_prefix()
	{
		$pd = new EmptyPropertyDescriptor($this->getProperty('empty'), $this->getClass());
		$this->assertEquals(array('prefix.empty' => 'EmptyClass'), $pd->describe('prefix'));
	}
}

?>