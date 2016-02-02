<?php

namespace Milhojas\Library\Mapper\Descriptor;

/**
* Describes a property with a simple value
*/
class PlainPropertyDescriptor extends AbstractPropertyDescriptor
{
	public function describe(\ReflectionProperty $property, $object, $prefix = null)
	{
		$property->setAccessible(true);
		return array($this->getQualifiedName($property, $prefix) => $property->getValue($object));
	}
	
}

?>