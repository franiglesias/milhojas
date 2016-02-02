<?php

namespace Milhojas\Library\Mapper\Descriptor;
/**
* Base class for property descriptors
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