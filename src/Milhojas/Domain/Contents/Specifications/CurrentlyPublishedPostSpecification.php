<?php

namespace Milhojas\Domain\Contents\Specifications;

/**
* Description
*/
class CurrentlyPublishedPostSpecification
{
	public function isSatisfiedBy($Post)
	{
		return $Post->isPublished(new \DateTimeImmutable());
	}
}

?>
