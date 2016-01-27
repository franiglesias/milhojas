<?php

namespace Library\Mapper;

/**
* Description
*/
class PlainPropertyDescriptor
{
	protected $property;
	protected $object;
	
	function __construct(\ReflectionProperty $property, $object)
	{
		$this->property = $property;
		$this->property->setAccessible(true);
		$this->object = $object;
	}
	
	public function describe($prefix = null)
	{
		$value = $this->property->getValue($this->object);
		return array($this->getQualifiedName($prefix) => $value);
	}
	
	protected function getQualifiedName($prefix)
	{
		return strtolower(($prefix ? $prefix.'.' : '').$this->property->getName());
	}
}

?>