<?php

namespace Tests\Library\Mapper\Descriptor;

use Milhojas\Library\Mapper\Descriptor\ObjectDescriptor;
use Milhojas\Library\Mapper\Descriptor\PropertyDescriptor;

use Tests\Library\Mapper\Utils\ClassWithAllPropertyTypes;
use Tests\Library\Mapper\Utils\EmptyClass;
use Tests\Library\Mapper\Utils\ClassWithPlainProperties;

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
		$descriptor = new ObjectDescriptor(new PropertyDescriptor());
		$description = array(
			'classwithplainproperties.id' => 1,
			'classwithplainproperties.content' => 'Content',
		);
		$this->assertEquals($description, $descriptor->describe($mc));
	}

	public function test_it_describes_class_with_members()
	{
		$c = $this->getClass();
		$descriptor = new ObjectDescriptor(new PropertyDescriptor());
		$description = array(
			'classwithallpropertytypes.id' => 1,
			'classwithallpropertytypes.member.id' => 1,
			'classwithallpropertytypes.member.content' => 'Content',
			'classwithallpropertytypes.empty' => 'EmptyClass'
		);
		$this->assertEquals($description, $descriptor->describe($c));
	}
	
	/**
	 * @expectedException \ReflectionException
	 */
	public function test_throws_exception_if_class_has_no_members()
	{
		$mc =  new EmptyClass();
		$descriptor = new ObjectDescriptor(new PropertyDescriptor());
		$descriptor->describe($mc);
	}

}


?>