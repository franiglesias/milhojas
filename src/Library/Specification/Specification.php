<?php

namespace Milhojas\Library\Specification;

interface Specification {
	/**
	 * @return boolean
	 */
	public function isSatisfiedBy($object);
	public function both(Specification $spec);
	public function either(Specification $spec);
	public function not();
}
?>