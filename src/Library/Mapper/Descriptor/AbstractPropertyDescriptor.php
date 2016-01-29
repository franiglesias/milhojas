<?php

namespace Library\Mapper\Descriptor;
/**
* Description
*/
abstract class AbstractPropertyDescriptor
{
	abstract public function describe(\ReflectionProperty $property, $object, $prefix = null);
	
	protected function getQualifiedName(\ReflectionProperty $property, $prefix)
	{
		return strtolower(($prefix ? $prefix.'.' : '').$property->getName());
	}
}

?>