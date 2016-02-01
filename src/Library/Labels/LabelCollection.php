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
		return $this->countCoincidences($labels) == count($labels);
	}
	
	public function hasSome($labels)
	{
		return $this->countCoincidences($labels) > 0;
	}
	
	public function not($labels)
	{
		return $this->countCoincidences($labels) == 0;
	}
	
	protected function prepareArray($labels)
	{
		$compare = array();
		foreach ((array)$labels as $label) {
			$compare[$this->getKey($label)] = $label;
		}
		return $compare;
	}
	
	protected function countCoincidences($labels)
	{
		return count(array_intersect_key($this->labels, $this->prepareArray($labels)));
	}
	
	private function getKey($label)
	{
		return trim(mb_strtolower($label));
	}
}

?>