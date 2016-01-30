<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\EmptyPropertyDescriptor;

class EmptyPropertyDescriptorTest extends AbstractPropertyDescriptorTestCase {
		
	public function test_it_describes_empty_property_as_class_name()
	{
		$pd = new EmptyPropertyDescriptor();
		$this->assertEquals(array('empty' => 'EmptyClass'), $pd->describe($this->getProperty('empty'), $this->getClass()));
	}
	
	public function test_it_describes_empty_property_as_class_name_with_prefix()
	{
		$pd = new EmptyPropertyDescriptor();
		$this->assertEquals(array('prefix.empty' => 'EmptyClass'), $pd->describe($this->getProperty('empty'), $this->getClass(), 'prefix'));
	}
}

?>