<?php

namespace Library\Specification;

use Library\Specification\AbstractSpecification;

/**
* Description
*/
class BothSpecification extends AbstractSpecification
{
	protected $left;
	protected $right;
	
	function __construct($left, $right)
	{
		$this->left = $left;
		$this->right = $right;
	}
	
	public function isSatisfiedBy($object)
	{
		return $this->left->isSatisfiedBy($object) && $this->right->isSatisfiedBy($object);
	}
}
?>