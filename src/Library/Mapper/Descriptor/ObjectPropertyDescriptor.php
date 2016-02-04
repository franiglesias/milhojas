<?php

namespace Milhojas\Library\Mapper\Descriptor;

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
		$description = array();
		$theProperty->setAccessible(true);
		$object = $theProperty->getValue($theObject);
		$prefix = $this->getQualifiedName($theProperty, $prefix);
		$properties = $this->getProperties($object);
		// foreach ($this->getProperties($object) as $property) {
		// 	$description += $this->PropertyDescriptor->describe($property, $object, $prefix);
		// }
		array_walk($properties, function ($property, $key) use (&$description, $object, $prefix) {
			$description += $this->PropertyDescriptor->describe($property, $object, $prefix);
		});
		return $description;
	}
	
	private function getProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


?>