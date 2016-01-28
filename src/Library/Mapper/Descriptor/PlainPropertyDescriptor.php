<?php

namespace Library\Mapper\Descriptor;
// use Library\Mapper\Descriptor\AbstractPropertyDescriptor;
/**
* Description
*/
class PlainPropertyDescriptor extends AbstractPropertyDescriptor
{
	protected $property;
	protected $object;
	
	public function describe($prefix = null)
	{
		return array($this->getQualifiedName($prefix) => $this->property->getValue($this->object));
	}
	
}

?>