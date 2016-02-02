<?php

namespace Milhojas\Library\Mapper\Descriptor;

/**
* Describes a property that is an object with no properties. i.e. state classes
*/
class EmptyPropertyDescriptor extends AbstractPropertyDescriptor
{
	public function describe(\ReflectionProperty $property, $object, $prefix = null)
	{
		$property->setAccessible(true);
		$r = new \ReflectionObject($property->getValue($object));
		return array($this->getQualifiedName($property, $prefix) => $r->getShortName());
	}
}


?>