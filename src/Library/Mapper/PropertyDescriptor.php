<?php

namespace Library\Mapper;

/**
* Factory of Specialized Property Descriptors
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
		return new EmptyPropertyDescriptor($property, $property->getValue($object));
	}
	
	static private function hasProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>