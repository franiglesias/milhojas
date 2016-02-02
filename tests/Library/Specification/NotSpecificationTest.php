<?php

namespace Tests\Library\Specification;

use Milhojas\Library\Specification\NotSpecification;

/**
* Description
*/
class NotSpecificationTest extends \PHPUnit_Framework_Testcase
{
	public function test_Not_Specification_true_is_false()
	{
		$NotSpec = new NotSpecification(new TrueSpecification());
		$this->assertFalse($NotSpec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_Not_Specification_false_is_true()
	{
		$NotSpec = new NotSpecification(new TrueSpecification());
		$this->assertTrue($NotSpec->isSatisfiedBy(new MyClass(false)));
	}
	
	
}


?>