<?php

namespace Library\Mapper;

use Library\Mapper\PlainPropertyDescriptor;
use Library\Mapper\PropertyDescriptor;
/**
* Description
*/
class ObjectPropertyDescriptor extends PlainPropertyDescriptor
{

	public function describe($prefix = null)
	{
		$object = $this->property->getValue($this->object);
		$description = array();
		foreach ($this->getProperties($object) as $property) {
			$descriptor = PropertyDescriptor::get($property, $object);
			$description += $descriptor->describe($this->getQualifiedName($prefix));
		}
		return $description;
	}
	
	private function getProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>