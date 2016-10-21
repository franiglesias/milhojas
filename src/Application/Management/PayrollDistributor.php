<?php

namespace Milhojas\Application\Management;

/**
* Represents Distribution of Payroll for a month
*/
class PayrollDistributor
{
	protected $month;
	protected $completed;
	protected $file;
	
	public function setMonth ($month)
	{
		$this->month = $month;
	}
	
	public function getMonth ()
	{
		return $this->month;
	}
	
	public function setCompleted ($date)
	{
		$this->date = $date;
	}
	
	public function getCompleted ()
	{
		return $this->date;
	}
	
	public function setFile ($file)
	{
		$this->file = $file;
	}
	
	public function getFile ()
	{
		return $this->file;
	}
	
	
}

?>
