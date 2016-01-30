<?php

namespace Library\Mapper\Descriptor;

/**
* Describes a property with a complex value
*/
class ObjectPropertyDescriptor extends AbstractPropertyDescriptor
{
	private $PropertyDescriptor;
	
	public function __construct($PropertyDescriptor)
	{
		$this->PropertyDescriptor = $PropertyDescriptor;
	}

	public function describe(\ReflectionProperty $theProperty, $theObject, $prefix = null)
	{
		$theProperty->setAccessible(true);
		$object = $theProperty->getValue($theObject);
		$description = array();
		foreach ($this->getProperties($object) as $property) {
			$description += $this->PropertyDescriptor->describe($property, $object, $this->getQualifiedName($theProperty, $prefix));
		}
		return $description;
	}
	
	private function getProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>