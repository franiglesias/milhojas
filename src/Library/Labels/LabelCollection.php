<?php

namespace Library\Labels;

class LabelCollection {
	private $labels;
	
	public function add($labels)
	{
		foreach ((array)$labels as $label) {
			$this->labels[$this->getKey($label)] = $label;
		}
	}
	
	public function has($labels)
	{
		$counter = 0;
		foreach ((array)$labels as $label) {
			$counter += array_key_exists($this->getKey($label), $this->labels);
		}
		return $counter > 0;
	}
	
	
	public function hasAll($labels)
	{
		$compare = $this->prepareCompareArray($labels);
		return count(array_intersect_key($this->labels, $compare)) == count($compare);
	}
	
	public function hasSome($labels)
	{
		$compare = $this->prepareCompareArray($labels);
		return count(array_intersect_key($this->labels, $compare)) > 0;
	}
	
	protected function prepareCompareArray($labels)
	{
		$compare = array();
		foreach ((array)$labels as $label) {
			$compare[$this->getKey($label)] = $label;
		}
		return $compare;
	}
	
	private function getKey($label)
	{
		return trim(mb_strtolower($label));
	}
}

?>