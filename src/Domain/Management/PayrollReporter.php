<?php

namespace Milhojas\Domain\Management;

use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* Is a Progress ValueObject descendant that can store statistical information about the Payroll sending process to generate a final report
*/
class PayrollReporter extends Progress
{
	private $sent;
	private $failed;
	private $notFound;
	
	public function __construct($current, $total)
	{
		$this->sent = 0;
		$this->failed = 0;
		$this->notFound = 0;
		parent::__construct($current, $total);
	}
	
	public function addSent()
	{
		$this->sent++;
		return clone $this;
	}
	
	public function getSent()
	{
		return $this->sent;
	}
	
	public function addNotFound()
	{
		$this->notFound++;
		return clone $this;
	}
	
	public function getNotFound()
	{
		return $this->notFound;
	}
	
	public function addFailed()
	{
		$this->failed++;
		return clone $this;
	}
	
	public function getFailed()
	{
		return $this->failed;
	}
	
}

?>
