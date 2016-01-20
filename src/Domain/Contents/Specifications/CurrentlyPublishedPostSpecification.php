<?php

namespace Domain\Contents\Specifications;

use Domain\Contents\Specifications\PostSpecificationInterface;
use Library\Specification\AbstractSpecification;
/**
* Description
*/
class CurrentlyPublishedPostSpecification extends AbstractSpecification
{
	public function isSatisfiedBy($Post)
	{
		return $Post->isPublished(new \DateTimeImmutable());
	}
}

?>