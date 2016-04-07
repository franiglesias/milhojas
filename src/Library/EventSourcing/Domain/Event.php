<?php

namespace Milhojas\Library\EventSourcing\Domain;

use Milhojas\Library\EventBus\Recordable;

interface Event extends Recordable{
	public function getName();
}

?>