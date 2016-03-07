<?php

namespace Milhojas\Infrastructure\Utilities;

/**
* A simple configurable Data Parser. Accepts a list of fields that describe the structure of the file
* null fields are skipped
* use first field as id field by default
*/
abstract class DataParser
{
	protected $fields;
	protected $id;
	
	function __construct(array $fields = array())
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
		return $this->removeUndesiredFileds(array_combine($this->fields, $parsedLine));
	}
	
	private function removeUndesiredFileds($row)
	{
		return array_filter($row, function($key) {
				return !empty($key);
			}, ARRAY_FILTER_USE_KEY);
	}
	
	private function fieldExists($field)
	{
		if (! in_array($field, $this->fields)) {
			throw new \InvalidArgumentException(sprintf('Field %s is not defined.', $field), 1);
		}
	}
}

?>