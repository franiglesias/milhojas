<?php

namespace Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\AbstractPropertyDescriptor;
use Library\Mapper\Descriptor\PropertyDescriptor;
/**
* Description
*/
class ObjectPropertyDescriptor extends AbstractPropertyDescriptor
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