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
	static function get(\ReflectionProperty $property, $object)
	{
		$property->setAccessible(true);
		if (!is_object($property->getValue($object))) {
			return new PlainPropertyDescriptor($property, $object);
		}
		if (self::hasProperties($property->getValue($object))) {
			return new ObjectPropertyDescriptor($property, $object);
		}
		return new EmptyPropertyDescriptor($property, $object);
	}
	
	static private function hasProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>