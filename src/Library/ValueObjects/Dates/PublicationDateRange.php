<?php


namespace Library\ValueObjects\Dates;

/**
* Description
*/
class PublicationDateRange
{
	private $Start;
	private $End;
	
	function __construct(\DateTimeImmutable $Start, \DateTimeImmutable $End = null)
	{
		$this->start = $Start;
		$this->validEnd($End);
		$this->end = $End;
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
		return new self($this->start, $End);
	}
	
	private function validEnd(\DateTimeImmutable $End = null)
	{
		if ($End && $End <= $this->start) {
			throw new \InvalidArgumentException('Expiration date must be at least a day after start day.');
		}
	}
}
?>