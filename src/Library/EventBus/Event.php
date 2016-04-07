<?php

namespace Milhojas\Library\EventBus;

use Milhojas\Library\EventBus\Recordable;

interface Event extends Recordable{
	public function getName();
}

?>