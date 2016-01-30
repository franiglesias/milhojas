<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\PropertyDescriptor;

class PropertyDescriptorTest extends \PHPUnit_Framework_Testcase {
	
	private function getClass()
	{
		return new Utils\ClassWithAllPropertyTypes(1, new Utils\EmptyClass(), new Utils\ClassWithPlainProperties(1, 'Content'));
	}
	
	public function getProperty($name)
	{
		$r = new \ReflectionObject($this->getClass());
		return $r->getProperty($name);
	}
	
	public function test_it_returns_plain_property_descriptor()
	{
		$descriptor = new PropertyDescriptor();
		$this->assertInstanceOf('Library\Mapper\Descriptor\PlainPropertyDescriptor', 
			$descriptor->getDescriptor($this->getProperty('id'), $this->getClass())
		);
	}
	
	public function test_it_returns_empty_property_descriptor()
	{
		$descriptor = new PropertyDescriptor();
		$this->assertInstanceOf('Library\Mapper\Descriptor\EmptyPropertyDescriptor', $descriptor->getDescriptor($this->getProperty('empty'), $this->getClass()));
	}
	
	public function test_it_returns_object_property_descriptor()
	{
		$descriptor = new PropertyDescriptor();
		$this->assertInstanceOf('Library\Mapper\Descriptor\ObjectPropertyDescriptor', $descriptor->getDescriptor($this->getProperty('member'), $this->getClass()));
	}
	
}

?>