<?php

namespace Library\Mapper\Descriptor;

// use Library\Mapper\Descriptor\PlainPropertyDescriptor;
// use Library\Mapper\Descriptor\ObjectPropertyDescriptor;
// use Library\Mapper\Descriptor\EmptyPropertyDescriptor;

/**
* Factory of Specialized Property Descriptors. It determines what class of property descriptor must return
*/
class PropertyDescriptor
{
	public function describe(\ReflectionProperty $property, $object, $prefix = null)
	{
		return $this->getDescriptor($property, $object)->describe($property, $object, $prefix);
	}
	
	public function getDescriptor(\ReflectionProperty $property, $object)
	{
		$property->setAccessible(true);
		if (!is_object($property->getValue($object))) {
			return new PlainPropertyDescriptor();
		}
		if ($this->hasProperties($property->getValue($object))) {
			return new ObjectPropertyDescriptor($this);
		}
		return new EmptyPropertyDescriptor();
	}
	
	private function hasProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>