<?php

namespace Domain\Contents\Specifications;

use Domain\Contents\Specifications\PostSpecificationInterface;

/**
* Description
*/
class CurrentlyPublishedPostSpecification implements PostSpecificationInterface
{
	public function isSatisfiedBy(\Domain\Contents\Post $Post)
	{
		return $Post->isPublished(new \DateTimeImmutable());
	}
}

?>