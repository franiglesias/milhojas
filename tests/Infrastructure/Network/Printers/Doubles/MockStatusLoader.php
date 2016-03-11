<?php

namespace Tests\Infrastructure\Network\Printers\Doubles;

use Milhojas\Infrastructure\Network\StatusLoader;

/**
* Description
*/
class MockStatusLoader implements StatusLoader
{
	private $status;
	
	function __construct($service, $toner, $paper)
	{
		$this->status = array(
			'service' => $service,
			'toner' => $toner,
			'paper' => $paper
		);
	}
	
	static public function working()
	{
		return new static(false, 5, 5);
	}
	
	static public function withoutPaper()
	{
		return new static(false, 5, 0);
	}

	static public function withoutToner()
	{
		return new static(false, 0, 5);
	}
	
	static public function needingService()
	{
		return new static('Error', 5, 5);
	}
	
	
	public function getStatus($force = false)
	{
		return $this->status;
	}
}

?>