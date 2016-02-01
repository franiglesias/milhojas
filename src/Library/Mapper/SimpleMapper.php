<?php

namespace Library\Mapper;

/**
* Description
*/
class SimpleMapper
{
	private $descriptor;
	
	function __construct(\Library\Mapper\Descriptor\ObjectDescriptor $descriptor)
	{
		$this->descriptor = $descriptor;
	}
	
	public function map($object, PopulatedFromMapper $dto)
	{
		$map = $this->descriptor->describe($object);
		$dto->fromMap($map);
		return $dto;
	}
}

?>