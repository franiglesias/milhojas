<?php

namespace Milhojas\Library\ValueObjects\Dates;

use  Milhojas\Library\ValueObjects\Dates\DateRange;

/**
* Description
*/
class OpenDateRange extends DateRange
{
	
	function __construct(\DateTimeImmutable $Start)
	{
		$this->start = $Start;
		$this->end = null;
	}
}

?>