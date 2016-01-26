<?php

namespace Domain\Contents\DTO;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class PostContent {
    /**
     * @ORM\Column(type="string", length=200)
     */
	protected $title;

    /**
     * @ORM\Column(type="text")
     */
	protected $body;
	
} 

?>