<?php

namespace Milhojas\Library\ValueObjects\Technical;

/**
* Description
*/
class Vendor
{
	private $vendor;
	private $model;
	
	function __construct($vendor, $model)
	{
		$this->vendor = $vendor;
		$this->model = $model;
	}
	
	public function getVendor()
	{
		return $this->vendor;
	}
	
	public function getModel()
	{
		return $this->model;
	}
	
	public function __toString()
	{
		return $this->vendor.' '.$this->model;
	}
}

?>