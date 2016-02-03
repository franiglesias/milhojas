<?php

namespace Tests\Library\Mapper\Descriptor;

use Milhojas\Library\Mapper\Descriptor\ObjectPropertyDescriptor;
use Milhojas\Library\Mapper\Descriptor\PropertyDescriptor;

use Tests\Library\Mapper\Utils\ClassWithAllPropertyTypes;
use Tests\Library\Mapper\Utils\EmptyClass;
use Tests\Library\Mapper\Utils\ClassWithPlainProperties;

class ObjectPropertyDescriptorTest extends AbstractPropertyDescriptorTestCase {
	
	public function test_it_describes_empty_property_as_class_name()
	{
		$pd = new ObjectPropertyDescriptor(new PropertyDescriptor());
		$this->assertEquals(array('member.id' => 1, 'member.content' => 'Content'), $pd->describe($this->getProperty('member'), $this->getClass()));
	}

	public function test_it_describes_empty_property_as_class_name_with_prefix()
	{
		$pd = new ObjectPropertyDescriptor(new PropertyDescriptor());
		$this->assertEquals(array('prefix.member.id' => 1, 'prefix.member.content' => 'Content'), $pd->describe($this->getProperty('member'), $this->getClass(), 'prefix'));
	}
}

?>