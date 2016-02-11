<?php

namespace Milhojas\Library\EventSourcing;

use Rhumsaa\Uuid\Uuid;
use Milhojas\Library\EventSourcing\EventStore\EntityData;
/**
* Contains metadata for event messages
*/
class EventMessageEnvelope
{
	private $id;
	private $time;
	private $metadata;
	
	private function __construct($id, $time, $metadata)
	{
		$this->id = $id;
		$this->time = $time;
		$this->metadata = $metadata;
	}
	
	static function now()
	{
		return new static(
			self::assignIdentity(),
			new \DateTimeImmutable(),
			array()
		);
	}
	
	static public function fromDTO($dto)
	{
		return new static(
			$dto->getId(),
			$dto->getTime(),
			$dto->getMetadata()
		);
	}
	
	static private function assignIdentity()
	{
		return Uuid::uuid4()->toString();
	}
	
	public function addMetaData($key, $value = null)
	{
		$data = $key;
		if (!is_array($key)) {
			$data = array($key => $value);
		}
		$this->metadata += $data;
	}
	
	public function getMetaData()
	{
		return $this->metadata;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getTime()
	{
		return $this->time;
	}
	
}

?>