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
	
	private function getKey($label)
	{
		return trim(mb_strtolower($label));
	}
}

?>