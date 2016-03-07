<?php

namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\DataParser;

/**
* Parses data form a tab file
*/
class TabDataParser extends DataParser
{
	
	protected function parseLine($line)
	{
		return explode(chr(9), $line);
	}
	
}

?>