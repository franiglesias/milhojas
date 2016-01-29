<?php

namespace Library\Mapper\Descriptor;

// use Library\Mapper\Descriptor\AbstractPropertyDescriptor;

/**
* Description
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