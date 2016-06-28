<?php

namespace Milhojas\Domain\Contents\DTO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_list")
 */
class PostList
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", nullable=FALSE)
	 */
	protected $title;
	
	public function __construct($id, $title)
	{
		$this->id = $id;
		$this->title = $title;
	}

	public function setId($id)
	{
		$this->id = $id;
	}
    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    } 
	public function setTitle($title)
	{
		$this->title = $title;
	}
	public function getTitle()
	{
		return $this->title;
	}
}
