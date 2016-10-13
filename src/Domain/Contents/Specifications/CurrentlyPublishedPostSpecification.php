<?php

namespace Milhojas\Domain\Contents\Specifications;

use Milhojas\Library\Specification\AbstractSpecification;
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
