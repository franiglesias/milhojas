<?php

namespace Library\Mapper\Descriptor;

// use Library\Mapper\Descriptor\AbstractPropertyDescriptor;
// use Library\Mapper\Descriptor\PropertyDescriptor;
/**
* Description
*/
class ObjectPropertyDescriptor extends AbstractPropertyDescriptor
{

	public function describe(\ReflectionProperty $theProperty, $theObject, $prefix = null)
	{
		$theProperty->setAccessible(true);
		$object = $theProperty->getValue($theObject);
		$description = array();
		foreach ($this->getProperties($object) as $property) {
			$descriptor = PropertyDescriptor::get($property, $object);
			$description += $descriptor->describe($property, $object, $this->getQualifiedName($theProperty, $prefix));
		}
		return $description;
	}
	
	private function getProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>