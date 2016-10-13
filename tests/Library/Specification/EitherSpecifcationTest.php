<?php

namespace Tests\Library\Specification;

use Milhojas\Library\Specification\EitherSpecification;

/**
* Description
*/
class EitherSpecificationTest extends \PHPUnit_Framework_Testcase
{
	public function test_Either_Specification_true_or_true_is_true()
	{
		$EitherSpec = new EitherSpecification(new TrueSpecification(), new TrueSpecification());
		$this->assertTrue($EitherSpec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_Either_Specification_true_or_false_is_true()
	{
		$EitherSpec = new EitherSpecification(new TrueSpecification(), new FalseSpecification());
		$this->assertTrue($EitherSpec->isSatisfiedBy(new MyClass(true)));
		$InvertedSpec = new EitherSpecification(new FalseSpecification(), new TrueSpecification());
		$this->assertTrue($InvertedSpec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_Either_Specification_false_or_false_is_false()
	{
		$EitherSpec = new EitherSpecification(new TrueSpecification(), new TrueSpecification());
		$this->assertFalse($EitherSpec->isSatisfiedBy(new MyClass(false)));
	}
	
}


?>
