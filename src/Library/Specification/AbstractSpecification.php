<?php

namespace Milhojas\Library\Specification;

abstract class AbstractSpecification implements SpecificationInterface
{
	abstract public function isSatisfiedBy($object);
	
	public function both(SpecificationInterface $Spec)
	{
		return new BothSpecification($this, $Spec);
	}
	
	public function either(SpecificationInterface $Spec)
	{
		return new EitherSpecification($this, $Spec);
	}
	
	public function not()
	{
		return new NotSpecification($this);
	}
}
?>