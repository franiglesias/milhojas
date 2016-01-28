<?php

namespace Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\PropertyDescriptor;

/**
 * Describes properties of an object
 *
 * @package milhojas/mapper
 * @author Fran Iglesias
 */

class ObjectDescriptor {
	
	private $object;
	private $description;
	
	public function __construct($object)
	{
		$this->object = $object;
	}
	public function describe($prefix = null)
	{
		$this->description = array();
		$reflect = new \ReflectionObject($this->object);
		$properties = $reflect->getProperties();
		foreach ($properties as $property) {
			$descriptor = PropertyDescriptor::get($property, $this->object);
			$this->description += $descriptor->describe($reflect->getShortName());
		}
		return $this->description;
	}
}



?>