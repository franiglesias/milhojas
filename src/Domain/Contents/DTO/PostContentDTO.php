<?php

namespace Domain\Contents\DTO;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class PostContentDTO {
    /**
     * @ORM\Column(type="string", length=200)
     */
	protected $title;

    /**
     * @ORM\Column(type="text")
     */
	protected $body;
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setBody($body)
	{
		$this->body = $body;
	}
	
} 

?>