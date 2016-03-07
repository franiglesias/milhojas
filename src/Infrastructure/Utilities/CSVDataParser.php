<?php


namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\AbstractDataParser;

/**
* Description
*/
class CSVDataParser extends AbstractDataParser
{
	public function parseLine($line)
	{
		return str_getcsv($line);
	}
}
?>