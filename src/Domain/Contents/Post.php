<?php

namespace Milhojas\Domain\Contents;

use Milhojas\Domain\Contents\PostId;
use Milhojas\Domain\Contents\PostStates as States;
use Milhojas\Domain\Contents\DTO\PostDTO as PostDTO;
use Milhojas\Domain\Contents\Events as Events;

use Milhojas\Library\ValueObjects\Dates\DateRange;
use Milhojas\Library\ValueObjects\Dates\OpenDateRange;
/**
* Represents a Post (an article)
*/
class Post
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
	
	static function write(PostId $id, PostContent $content)
	{
		$post = new self();
		$post->apply(new Events\NewPostWritten($id->getId(), $content->getTitle(), $content->getBody(), 'author'));
		return new self($id, $content);
	}
	
	public function apply($event)
	{
		$method = get_class($event);
		$method = 'apply'.substr($method, strrpos($method, '\\')+1);
		$this->$method($event);
	}
	
	protected function applyNewPostWritten(Events\NewPostWritten $event)
	{
		$this->id = new PostId($event->getAggregateId());
		$this->content = new PostContent($event->getTitle(), $event->getBody());
		$this->author = $event->getAuthor();
	}
	
	public function publish(DateRange $publication)
	{
		$this->state = $this->state->publish();
		$this->publication = $publication;
	}
	
	public function isPublished(\DateTimeImmutable $Date = null)
	{
		if (!$Date) {
			$Date = new \DateTimeImmutable();
		}
		return ($this->state == new \Milhojas\Domain\Contents\PostStates\PublishedPostState()) && $this->publication->includes($Date);
	}
	
	public function addFlag(Flags\Flag $flag)
	{
		$this->flags->add($flag);
	}
	
	public function hasFlag(Flags\Flag $flag)
	{
		return $this->flags->has($flag);
	}
	
	public function removeFlag(Flags\Flag $flag)
	{
		$this->flags->remove($flag);
	}
		
	public function retire()
	{
		$this->state = $this->state->retire();
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getState()
	{
		return $this->state;
	}
	
}

?>