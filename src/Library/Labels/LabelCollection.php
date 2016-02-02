<?php

namespace Library\Labels;

class LabelCollection {
	
	private $labels;
	
	public function __construct()
	{
		$this->labels = [];
	}
	public function add($labels)
	{
		$this->labels += $this->normalize($labels);
	}
	
	public function has($labels)
	{
		return $this->hasAll($labels);
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
	
	public function count()
	{
		return count($this->labels);
	}
	
	protected function normalize($labels)
	{
		$labels = (array)$labels;
		$keys = $labels;
		array_walk($keys, function(&$label, $key) {
			$label = trim(mb_strtolower($label));
			$label = str_replace(' ', '_', $label);
		});
		return array_combine($keys, $labels);
	}
	
	protected function countCoincidences($labels)
	{
		return count(array_intersect_key($this->labels, $this->normalize($labels)));
	}
	
}

?>