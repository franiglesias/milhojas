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
	
	private $object;
	
	public function __construct($object)
	{
		$this->object = $object;
	}
	public function describe()
	{
		$description = array();
		$reflect = new \ReflectionObject($this->object);
		$properties = $reflect->getProperties();
		if (!$properties) {
			throw new \ReflectionException(sprintf('Class %s has no properties.',$reflect->getName() ));
		}
		foreach ($properties as $property) {
			$descriptor = PropertyDescriptor::get($property, $this->object);
			$description += $descriptor->describe($reflect->getShortName());
		}
		return $description;
	}
}



?>