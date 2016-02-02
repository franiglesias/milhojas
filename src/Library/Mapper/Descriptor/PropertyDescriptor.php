<?php

namespace Milhojas\Library\Mapper\Descriptor;

/**
* Composite of Property Descriptors. It determines what class of property descriptor should do the work;
*/

class PropertyDescriptor
{
	public function describe(\ReflectionProperty $property, $object, $prefix = null)
	{
		return $this->getDescriptor($property, $object)
			->describe($property, $object, $prefix);
	}
	
	public function getDescriptor(\ReflectionProperty $property, $object)
	{
		$property->setAccessible(true);
		if (!is_object($property->getValue($object))) {
			return new PlainPropertyDescriptor();
		}
		if ($this->objectValueHasProperties($property->getValue($object))) {
			return new ObjectPropertyDescriptor($this);
		}
		return new EmptyPropertyDescriptor();
	}
	
	private function objectValueHasProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>