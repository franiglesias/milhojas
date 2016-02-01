<?php

namespace Tests\Library\Labels;

use Library\Labels\LabelCollection;

class LabelCollectionTest extends \PHPUnit_Framework_Testcase {
	
	
	public function getTestData()
	{
		return array(
			'Test 1',
			'Test 2',
			'Test 3'
		);
	}
	
	public function getCollection($elements = 10)
	{
		$data = array();
		for ($i=1; $i < $elements+1; $i++) { 
			$data['test'.$i] = 'Test '.$i; 
		}
		$c = new LabelCollection();
		$c->add($data);
		return $c;

	}
	public function test_it_creates_a_label_colletion()
	{
		$labels = $this->getCollection();
		$this->assertTrue($labels->has('Test 1'));
	}
	
	public function test_it_has_all_labels()
	{
		$labels = $this->getCollection();
		$this->assertTrue($labels->hasAll(array('Test 1', 'Test 3', 'Test 4')));
		$this->assertFalse($labels->hasAll(array('Test 34', 'Test 2')));
		$this->assertFalse($labels->hasAll(array('No label', 'False label')));
	}
	
	public function test_it_has_some_labels()
	{
		$labels = $this->getCollection();
		$this->assertTrue($labels->hasSome(array('Test 1', 'Test 3', 'Test 4')));
		$this->assertTrue($labels->hasSome(array('Test 34', 'Test 2')));
		$this->assertFalse($labels->hasSome(array('No label', 'False label')));
		
	}
	
	public function test_it_has_none_of_these_labels()
	{
		$labels = $this->getCollection();
		$this->assertFalse($labels->not(array('Test 1', 'Test 3', 'Test 4')));
		$this->assertFalse($labels->not(array('Test 34', 'Test 2')));
		$this->assertTrue($labels->not(array('No label', 'False label')));
	}
	
}
?>