<?php

namespace Milhojas\Library\Mapper;

use Milhojas\Library\Mapper\Descriptor\PropertyDescriptor;

class ObjectMapper implements Mapper{
	
	private $PropertyDescriptor;
	
	public function __construct(PropertyDescriptor $PropertyDescriptor)
	{
		$this->PropertyDescriptor = $PropertyDescriptor;
	}

	public function map($object)
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
