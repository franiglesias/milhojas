<?php

namespace Tests\Library\Mapper\Descriptor;

use Milhojas\Library\Mapper\Descriptor\PlainPropertyDescriptor;

use Tests\Library\Mapper\Utils\ClassWithAllPropertyTypes;
use Tests\Library\Mapper\Utils\EmptyClass;
use Tests\Library\Mapper\Utils\ClassWithPlainProperties;

class PlainPropertyDescriptorTest extends AbstractPropertyDescriptorTestCase {
	
	public function test_it_describes_plain_property()
	{
		$pd = new PlainPropertyDescriptor();
		$this->assertEquals(array('id' => 1), $pd->describe($this->getProperty('id'), $this->getClass()));
	}
	
	public function test_it_describes_plain_property_2_with_prefix()
	{
		$pd = new PlainPropertyDescriptor();
		$this->assertEquals(array('prefix.id' => 1), $pd->describe($this->getProperty('id'), $this->getClass(), 'prefix'));
	}
	
}

?>