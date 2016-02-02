<?php

namespace Milhojas\Tests\Library\Mapper\Descriptor;

// Abstract base class for PropertyDescriptor Tests with some common methods

class AbstractPropertyDescriptorTestCase extends \PHPUnit_Framework_Testcase {
	
	protected function getClass()
	{
			return new Utils\ClassWithAllPropertyTypes(1, new Utils\EmptyClass(), new Utils\ClassWithPlainProperties(1, 'Content'));
	}
	
	protected function getProperty($name)
	{
		$r = new \ReflectionObject($this->getClass());
		return $r->getProperty($name);
	}

}

?>