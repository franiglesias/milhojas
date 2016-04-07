<?php

namespace Milhojas\Library\EventSourcing\Domain;

use Milhojas\Library\EventSourcing\EventStream\Recordable;

interface Event extends Recordable{
	public function getName();
}

?>