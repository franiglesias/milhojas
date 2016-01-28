<?php

namespace Library\Mapper\Descriptor;
/**
* Description
*/
abstract class AbstractPropertyDescriptor
{
	protected $property;
	protected $object;
	
	function __construct(\ReflectionProperty $property, $object)
	{
		$this->property = $property;
		$this->property->setAccessible(true);
		$this->object = $object;
	}
	
	abstract public function describe($prefix = null);
	
	protected function getQualifiedName($prefix)
	{
		return strtolower(($prefix ? $prefix.'.' : '').$this->property->getName());
	}
}

?>