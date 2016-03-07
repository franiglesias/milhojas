<?php

namespace Milhojas\Infrastructure\Utilities;

/**
* A simple configurable Data Parser. Accepts a list of fields that describe the structure of the file
* null fields are skipped
* use first field as id field by default
*/
class DataParser
{
	private $fields;
	private $id;
	
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
	
	public function asTab(array $data)
	{
		$tab = array();
		foreach ($data as $line) {
			$parsed = array_combine($this->fields, explode(chr(9), $line));
			$parsed = $this->removeUndesiredFields($parsed);
			$tab[$parsed[$this->id]] = $parsed;
		}
		return $tab;
	}
	
	private function removeUndesiredFields($data)
	{
		return array_filter($data, function($key) {
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