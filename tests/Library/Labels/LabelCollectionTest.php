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
	
	
	
	public function test_array_intersect()
	{
		$labels = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
			'prueba' => 'Prueba'
		);
		
		$has = array(
			'prueba' => 'Prueba'
		);	
		
		$result = array_intersect_key($has, $labels);
		
		$this->assertEquals(1, count($result));
		$this->assertEquals($has, $result);
	}
	
	public function test_array_diff()
	{
		$labels = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
			'prueba' => 'Prueba'
		);
		
		$has = array(
			'prueba' => 'Prueba'
		);	
		
		$result = array_diff_key($labels, $has);
		
		$expected = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
		);
		
		$this->assertEquals(2, count($result));
		$this->assertEquals($expected, $result);
	}
	
	public function test_array_has_all_keys()
	{
		$labels = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
			'prueba' => 'Prueba'
		);
		
		$has = array(
			'prueba' => true,
			'test' => true
		);	
		
		$result = array_intersect_key($labels, $has);
		
		$expected = array(
			'test' => 'Test',
			'prueba' => 'Prueba',
		);
		
		$this->assertEquals(2, count($result));
		$this->assertEquals($expected, $result);
		
	}
	
	public function test_array_has_some_keys()
	{
		$labels = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
			'prueba' => 'Prueba'
		);
		
		$has = array(
			'prueba' => true,
			'test' => true
		);	
		
		$result = array_intersect_key($labels, $has);
		
		$expected = array(
			'test' => 'Test',
			'prueba' => 'Prueba',
		);
		
		$this->assertGreaterThan(0, count($result));
		$this->assertEquals($expected, $result);
		
	}
	
	public function test_array_has_no_keys()
	{
		$labels = array(
			'test' => 'Test',
			'myLabel' => 'My Label',
			'prueba' => 'Prueba'
		);
		
		$has = array(
			'foo' => true,
			'bar' => true
		);	
		
		$result = array_intersect_key($labels, $has);
		
		$expected = array();
		
		$this->assertEquals($expected, $result);
		
	}
	
}
?>