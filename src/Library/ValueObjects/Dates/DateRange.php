<?php


namespace Milhojas\Library\ValueObjects\Dates;

/**
* Description
*/
class DateRange
{
	private $start;
	private $end;
	
	function __construct(\DateTimeImmutable $Start, \DateTimeImmutable $End = null)
	{
		$this->start = $Start;
		$this->validEnd($End);
		$this->end = $End;
	}
	
	static public function open(\DateTimeImmutable $Start)
	{
		return new self($Start, null);
	}
	
	public function includes(\DateTimeImmutable $Test)
	{
		if ($this->end) {
			return ($Test >= $this->start && $Test <= $this->end);
		}
		return ($Test >= $this->start);
	}
	
	public function changeStart(\DateTimeImmutable $Start)
	{
		return new self($Start, $this->end);
	}
	
	public function changeExpiration(\DateTimeImmutable $End = null)
	{
		if (is_null($End)) {
			return new OpenDateRange($this->start);
		}
		return new self($this->start, $End);
	}
	
	private function validEnd(\DateTimeImmutable $End = null)
	{
		if ($End && $End <= $this->start) {
			throw new \InvalidArgumentException('Expiration date must be at least a day after start day.');
		}
	}
	
	public function getStart()
	{
		return $this->start;
	}
	
	public function getEnd()
	{
		return $this->end;
	}
}
?>