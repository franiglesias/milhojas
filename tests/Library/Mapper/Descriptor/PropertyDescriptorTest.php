<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\PropertyDescriptor;

class PropertyDescriptorTest extends \PHPUnit_Framework_Testcase {
	
	private function getClass()
	{
		return new ClassWithAllPropertyTypes(1, new EmptyClass(), new ClassWithPlainProperties(1, 'Content'));
	}
	
	public function getProperty($name)
	{
		$r = new \ReflectionObject($this->getClass());
		return $r->getProperty($name);
	}
	
	public function test_it_returns_plain_property_descriptor()
	{
		$descriptor = PropertyDescriptor::get($this->getProperty('id'), $this->getClass());
		$this->assertInstanceOf('Library\Mapper\Descriptor\PlainPropertyDescriptor', $descriptor);
	}
	
	public function test_it_returns_empty_property_descriptor()
	{
		$descriptor = PropertyDescriptor::get($this->getProperty('empty'), $this->getClass());
		$this->assertInstanceOf('Library\Mapper\Descriptor\EmptyPropertyDescriptor', $descriptor);
	}
	
	public function test_it_returns_object_property_descriptor()
	{
		$descriptor = PropertyDescriptor::get($this->getProperty('member'), $this->getClass());
		$this->assertInstanceOf('Library\Mapper\Descriptor\ObjectPropertyDescriptor', $descriptor);
	}
	
}

?>