<?php

namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\DataParser;

/**
* A simple configurable Data Parser. Accepts a list of fields that describe the structure of the file
* null fields are skipped
* use first field as id field by default
*/
class TabDataParser extends DataParser
{
	
	protected function parseLine($line)
	{
		return explode(chr(9), $line);
	}
	
}

?>