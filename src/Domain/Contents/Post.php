<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostStates as States;
use Milhojas\Domain\Contents\DTO\PostDTO as PostDTO;

use Milhojas\Library\ValueObjects\Dates\DateRange;
use Milhojas\Library\ValueObjects\Dates\OpenDateRange;

use Milhojas\Library\EventSourcing\Domain\EventSourcedEntity;
/**
* Represents a Post (an article)
*/
class Post extends EventSourcedEntity
{
	private $id;
	private $content;
	
	private $state;
	
	private $publication;
	
	private $flags;
	
	private $tags;
	private $authors;
	private $attachments;
	
	private function __construct()
	{
		$this->state = new States\DraftPostState();
		$this->flags = new Flags\FlagCollection(new \SplObjectStorage());
		$this->publication = new OpenDateRange(new \DateTimeImmutable());
	}
	
	static function write(PostId $id, PostContent $content, $author = '')
	{
		$post = new self();
		$post->id = $id;
		$post->apply(new Events\NewPostWritten($id->getId(), $content->getTitle(), $content->getBody(), $author));
		return $post;
	}

	protected function applyNewPostWritten(Events\NewPostWritten $event)
	{
		$this->id = new PostId($event->getEntityId());
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function update(PostContent $newContent, $author = '')
	{
		$this->apply(new Events\PostUpdated($this->getEntityId(), $newContent->getTitle(), $newContent->getBody(), $author));
	}
	
	protected function applyPostUpdated(Events\PostUpdated $event)
	{
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function publish(DateRange $publication)
	{
		$this->state = $this->state->publish();
		$this->apply(new Events\PostPublished($this->getEntityId(), $publication->getStart(), $publication->getEnd()));
	}
	
	protected function applyPostPublished(Events\PostPublished $event)
	{
		$this->publication = new DateRange($event->getPublication(), $event->getExpiration());
		$this->state = new States\PublishedPostState();
	}
	
	public function isPublished(\DateTimeImmutable $Date = null)
	{
		if (!$Date) {
			$Date = new \DateTimeImmutable();
		}
		return ($this->state == new States\PublishedPostState()) && $this->publication->includes($Date);
	}
			
	public function retire()
	{
		$this->state = $this->state->retire();
		$this->apply(new Events\PostRetired($this->getEntityId()));
	}
	
	protected function applyPostRetired(Events\PostRetired $event)
	{
		$this->state = new States\RetiredPostState();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getEntityId()
	{
		return $this->id->getId();
	}
	
	public function getState()
	{
		return $this->state;
	}
	
}

?>