<?php

namespace Milhojas\Infrastructure\Utilities;

/**
* A simple configurable Data Parser. 
* Parses an array of data. Every element is a "row" that can be parsed
* Constructor accepts a list of fields that describe the structure of the columns, null fields are skipped
* By default it uses the first field as the id field by default, or setId($field) with a existent field
* 
* Extend with template method pattern
*/
abstract class DataParser
{
	protected $fields;
	protected $id;
public function __construct(array $fields = array())
	{
		$this->fields = $fields;
		$this->id = $this->fields[0];
	}
	
	public function defineFields(array $fields)
	{
		$this->fields = $fields;
		if (! $this->id) {
			$this->id = $this->fields[0];
		}
	}
	
	public function setId($field)
	{
		$this->fieldExists($field);
		$this->id = $field;
	}
	
	public function parse(array $data)
	{
		$tab = array();
		foreach ($data as $line) {
			$parsed = $this->assignFields($this->parseLine($line));
			$tab[$parsed[$this->id]] = $parsed;
		}
		return $tab;
	}
	
	abstract protected function parseLine($line);
	
	private function assignFields($parsedLine)
	{
		return $this->removeUndesiredFields(array_combine($this->fields, $parsedLine));
	}
	
	private function removeUndesiredFields($row)
	{
		$removeEmptyKeys = function (&$value, $key) {
			$value = trim($value);
			return !empty($key);
		};
		return array_filter($row, $removeEmptyKeys, ARRAY_FILTER_USE_BOTH);
	}
	
	private function fieldExists($field)
	{
		if (! in_array($field, $this->fields)) {
			throw new \InvalidArgumentException(sprintf('Field %s is not defined.', $field), 1);
		}
	}
}

?>
