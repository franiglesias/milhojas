<?php

namespace Library\Mapper\Descriptor;

// use Library\Mapper\Descriptor\PropertyDescriptor;

/**
 * Describes properties of an object
 *
 * @package milhojas/mapper
 * @author Fran Iglesias
 */

class ObjectDescriptor {
	
	public function __construct()
	{
	}

	public function describe($object)
	{
		$description = array();
		$reflect = new \ReflectionObject($object);
		$properties = $reflect->getProperties();
		if (!$properties) {
			throw new \ReflectionException(sprintf('Class %s has no properties.',$reflect->getName() ));
		}
		foreach ($properties as $property) {
			$descriptor = PropertyDescriptor::get($property, $object);
			$description += $descriptor->describe($reflect->getShortName());
		}
		return $description;
	}
}



?>