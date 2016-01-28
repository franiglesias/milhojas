<?php

namespace Tests\Library\Mapper\Descriptor;

// Include this file to access class to use in tests

// Sample classes

class ClassWithAllPropertyTypes
{
	private $id;
	private $empty;
	private $member;
	
	function __construct($id, EmptyClass $empty, ClassWithPlainProperties $member)
	{
		$this->id = $id;
		$this->empty = $empty;
		$this->member = $member;
	}
}

class EmptyClass
{
}

class ClassWithPlainProperties {
	
	private $id;
	private $content;
	
	public function __construct($id, $content)
	{
		$this->id = $id;
		$this->content = $content;
	}
}

// Abstract base class for PropertyDescriptor Tests with some common methods

class AbstractPropertyDescriptorTest extends \PHPUnit_Framework_Testcase {
	
	protected function getClass()
	{
		return new ClassWithAllPropertyTypes(1, new EmptyClass(), new ClassWithPlainProperties(1, 'Content'));
	}
	
	protected function getProperty($name)
	{
		$r = new \ReflectionObject($this->getClass());
		return $r->getProperty($name);
	}

}


?>