<?php

namespace Tests\Library\Labels;

use Library\Labels\LabelCollection;

class LabelCollectionTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_creates_a_label_colletion()
	{
		$labels = new LabelCollection();
		$labels->add(array('Test', 'A label', 'Story'));
		$this->assertTrue($labels->has('Test'));
	}
}
?>