<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventSourcing\EventStream\Recordable;

interface Event extends Recordable{
	public function getName();
}

?>