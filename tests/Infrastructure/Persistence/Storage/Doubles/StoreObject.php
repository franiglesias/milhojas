<?php

namespace Tests\Infrastructure\Persistence\Storage\Doubles;

/**
* A simple object to use in tests
*/

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="storeobject")
 */
class StoreObject
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
	private $id;
	
    /**
     * @ORM\Column(type="string")
     */
	private $value;
	
	function __construct($id, $value = null)
	{
		$this->setId($id);
		$this->setValue($value);
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getValue()
	{
		return $this->value;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}
}

?>