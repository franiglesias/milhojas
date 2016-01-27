<?php

namespace Library\Mapper;

/**
* Description
*/
class EmptyPropertyDescriptor extends PlainPropertyDescriptor
{
	public function describe($prefix = null)
	{
		$r = new \ReflectionObject($this->object);
		return array($this->getQualifiedName($prefix) => $r->getShortName());
	}
}


?>