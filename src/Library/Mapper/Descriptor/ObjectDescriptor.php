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
	
	private $PropertyDescriptor;
	
	public function __construct($PropertyDescriptor)
	{
		$this->PropertyDescriptor = $PropertyDescriptor;
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
			$description += $this->PropertyDescriptor->describe($property, $object, $reflect->getShortName());
		}
		return $description;
	}
}



?>