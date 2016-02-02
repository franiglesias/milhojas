<?php

namespace Milhojas\Domain\Contents\Specifications;

interface PostSpecificationInterface {
	/**
	 * undocumented function
	 *
	 * @param Post $Post 
	 * @return boolean
	 * @author Fran Iglesias
	 */
	public function isSatisfiedBy(\Milhojas\Domain\Contents\Post $Post);
}
?>