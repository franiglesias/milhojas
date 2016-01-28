<?php

namespace Tests\Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\ObjectDescriptor;

include_once('TestClasses.php');

class ObjectDescriptorTest extends \PHPUnit_Framework_Testcase{
	
	private function getClass()
	{
		return new ClassWithAllPropertyTypes(1, new EmptyClass(), new ClassWithPlainProperties(1, 'Content'));
	}
	
	private function getProperty($name)
	{
		$r = new \ReflectionObject($this->getClass());
		return $r->getProperty($name);
	}
	
	public function test_it_describes_simple_class()
	{
		$mc =  new ClassWithPlainProperties(1, 'Content');
		$descriptor = new ObjectDescriptor($mc);
		$description = array(
			'classwithplainproperties.id' => 1,
			'classwithplainproperties.content' => 'Content',
		);
		$this->assertEquals($description, $descriptor->describe());
	}

	public function test_it_describes_class_with_members()
	{
		$c = $this->getClass();
		$descriptor = new ObjectDescriptor($c);
		$description = array(
			'classwithallpropertytypes.id' => 1,
			'classwithallpropertytypes.member.id' => 1,
			'classwithallpropertytypes.member.content' => 'Content',
			'classwithallpropertytypes.empty' => 'EmptyClass'
		);
		$this->assertEquals($description, $descriptor->describe());
	}
	
	/**
	 * @expectedException \ReflectionException
	 */
	public function test_throws_exception_if_class_has_no_members()
	{
		$mc =  new EmptyClass();
		$descriptor = new ObjectDescriptor($mc);
		$descriptor->describe();
	}

}


?>