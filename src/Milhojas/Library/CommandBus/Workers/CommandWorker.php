<?php

namespace Milhojas\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\ChainableCommandWorker;

/**
 * Base class for Chainable Command Workers. Manages the next pointer and encapsulates delegation.
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
abstract class CommandWorker implements ChainableCommandWorker
{
	protected $next;
	
	public function setNext(ChainableCommandWorker $next)
	{
		$this->next = $next;
	}
	
	protected function delegateNext(Command $command)
	{
		if (!$this->next) {
			return;
		}
		$this->next->execute($command);
	}
}

?>
