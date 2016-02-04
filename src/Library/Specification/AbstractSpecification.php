<?php

namespace Milhojas\Library\Specification;

abstract class AbstractSpecification implements Specification
{
	abstract public function isSatisfiedBy($object);
	
	public function both(Specification $Spec)
	{
		return new BothSpecification($this, $Spec);
	}
	
	public function either(Specification $Spec)
	{
		return new EitherSpecification($this, $Spec);
	}
	
	public function not()
	{
		return new NotSpecification($this);
	}
}
?>