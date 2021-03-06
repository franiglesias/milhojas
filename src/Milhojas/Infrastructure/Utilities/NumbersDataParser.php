<?php


namespace Milhojas\Infrastructure\Utilities;

use Milhojas\Infrastructure\Utilities\DataParser;

/**
* Parses data from a CSV file generated by Numbers
* Separator: ;
* Fields are not delimited
*/
class NumbersDataParser extends DataParser
{
	public function parseLine($line)
	{
		return str_getcsv($line, ';', '');
	}
}

?>
