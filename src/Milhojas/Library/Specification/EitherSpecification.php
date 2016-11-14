<?php

namespace Milhojas\Library\Specification;

use Milhojas\Library\Specification\AbstractSpecification;

/**
* Description
*/
class EitherSpecification extends AbstractSpecification
{
	protected $left;
	protected $right;
	
	public function __construct($left, $right)
	{
		$this->left = $left;
		$this->right = $right;
	}
	
	public function isSatisfiedBy($object)
	{
		return $this->left->isSatisfiedBy($object) || $this->right->isSatisfiedBy($object);
	}
}
?>
