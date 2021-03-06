<?php

namespace Milhojas\Application\Contents\Command;

use Milhojas\Messaging\CommandBus\Command;
use Milhojas\Messaging\CommandBus\CommandHandler;

use Milhojas\Domain\Contents\PostRepository;

use Milhojas\Domain\Contents\Post;
use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostContent;

use Milhojas\Messaging\EventBus\EventRecorder;

/**
* Update a post, identified by id, with new data for title and body
* Records domain events
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
		$this->recorder->load($Post->getPlainEvents());
		$this->repository->save($Post);
	}
}

?>
