<?php

namespace Domain\Contents\Specifications;

interface PostSpecificationInterface {
	public function isSatisfiedBy(\Domain\Contents\Post $Post);
}
?>