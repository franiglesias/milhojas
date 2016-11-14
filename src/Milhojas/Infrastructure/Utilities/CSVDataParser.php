<?php


namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\DataParser;

/**
* Parses data from a CSV file separated by , (comma) and delimited with double quotes (")
*/
class CSVDataParser extends DataParser
{
	public function parseLine($line)
	{
		return str_getcsv($line);
	}
}
?>
