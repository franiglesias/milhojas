<?php

namespace Domain\Contents\Specifications;

interface PostSpecificationInterface {
	/**
	 * undocumented function
	 *
	 * @param Post $Post 
	 * @return boolean
	 * @author Fran Iglesias
	 */
	public function isSatisfiedBy(\Domain\Contents\Post $Post);
}
?>