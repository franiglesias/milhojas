<?php

namespace Library\Mapper\Descriptor;
// use Library\Mapper\Descriptor\AbstractPropertyDescriptor;
/**
* Description
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