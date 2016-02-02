<?php

namespace Milhojas\Library\Specification;

interface SpecificationInterface {
	/**
	 * @return boolean
	 */
	public function isSatisfiedBy($object);
	public function both(SpecificationInterface $spec);
	public function either(SpecificationInterface $spec);
	public function not();
}
?>