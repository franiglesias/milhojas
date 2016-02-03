<?php

namespace Tests\Library\Mapper\Descriptor;
use Tests\Library\Mapper\Utils\ClassWithAllPropertyTypes;
use Tests\Library\Mapper\Utils\EmptyClass;
use Tests\Library\Mapper\Utils\ClassWithPlainProperties;

// Abstract base class for PropertyDescriptor Tests with some common methods

class AbstractPropertyDescriptorTestCase extends \PHPUnit_Framework_Testcase {
	
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