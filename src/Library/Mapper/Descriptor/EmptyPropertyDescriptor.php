<?php

namespace Library\Mapper\Descriptor;

use Library\Mapper\Descriptor\AbstractPropertyDescriptor;

/**
* Description
*/
class EmptyPropertyDescriptor extends AbstractPropertyDescriptor
{
	public function describe($prefix = null)
	{
		$r = new \ReflectionObject($this->object);
		return array($this->getQualifiedName($prefix) => $r->getShortName());
	}
}


?>