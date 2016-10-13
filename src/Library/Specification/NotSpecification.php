<?php

namespace Milhojas\Library\Specification;

use Milhojas\Library\Specification\AbstractSpecification;

/**
* Description
*/
class NotSpecification extends AbstractSpecification
{
	protected $spec;
public function __construct($spec)
	{
		$this->spec = $spec;
	}
	
	public function isSatisfiedBy($object)
	{
		return !$this->spec->isSatisfiedBy($object);
	}
}
?>
