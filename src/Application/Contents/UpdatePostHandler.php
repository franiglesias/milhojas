<?php

namespace Milhojas\Application\Contents;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Domain\Contents\PostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;

use Milhojas\Library\EventSourcing\EventStream\EventRecorder;


/**
* Description
*/
class UpdatePostHandler implements CommandHandler
{
	private $repository;
	private $recorder;
	
	public function __construct(PostRepository $repository, EventRecorder $recorder)
	{
		$this->repository = $repository;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$Post = $this->repository->get(new PostId($command->getId()));
		$Post->update(new PostContent($command->getTitle(), $command->getBody()));
		// Get the events and send to an EventProvider??
		$this->recorder->load($Post->retrieveEvents());
		$Post->clearEvents();
		$this->repository->save($Post);
	}
}


?>