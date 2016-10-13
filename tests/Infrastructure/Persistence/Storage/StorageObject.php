<?php

namespace Tests\Infrastructure\Persistence\Storage;

use Milhojas\Library\ValueObjects\Identity\Id;

/**
* Simple Dummy Object to Store
*/

class StorageObject
{
public function __construct(Id $id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
}

?>
