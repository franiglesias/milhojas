<?php

namespace Domain\Contents;

use Domain\Contents\PostId;
use Domain\Contents\PostStates as States;

use Library\ValueObjects\Dates\DateRange;
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
	
	function __construct(PostId $id, PostContent $content)
	{
		$this->id = $id;
		$this->content = $content;
		$this->state = new States\DraftPostState();
		$this->flags = new \SplObjectStorage();

	}
	
	static function write(PostId $id, PostContent $content)
	{
		return new self($id, $content);
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
		return ($this->state == new \Domain\Contents\PostStates\PublishedPostState()) && $this->publication->includes($Date);
	}
	
	public function addFlag(Flags\FlagInterface $flag)
	{
		$this->flags->attach($flag);
	}
	
	public function hasFlag(Flags\FlagInterface $flag)
	{
		return $this->flags->contains($flag);
	}
	
	public function removeFlag(Flags\FlagInterface $flag)
	{
		$this->flags->detach($flag);
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