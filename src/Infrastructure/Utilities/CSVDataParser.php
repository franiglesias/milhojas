<?php


namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\DataParser;

/**
* Description
*/
class CSVDataParser extends DataParser
{
	public function parseLine($line)
	{
		return str_getcsv($line);
	}
}
?>