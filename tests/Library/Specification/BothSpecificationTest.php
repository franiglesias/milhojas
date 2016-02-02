<?php

namespace Tests\Library\Specification;

use Milhojas\Library\Specification\BothSpecification;


class MyClass {
	
	private $value;
	
	public function __construct($value)
	{
		$this->value = $value;
	}
	public function value()
	{
		return $this->value;
	}
}
/**
* Description
*/
class TrueSpecification extends \Milhojas\Library\Specification\AbstractSpecification
{
	public function isSatisfiedBy($object)
	{
		return $object->value() === true;
	}
}


/**
* Description
*/
class FalseSpecification extends \Milhojas\Library\Specification\AbstractSpecification
{
	public function isSatisfiedBy($object)
	{
		return $object->value() === false;
	}
	
}


/**
* Description
*/
class BothSpecificationTest extends \PHPUnit_Framework_Testcase
{
	public function test_Both_Specification_true_and_true_is_true()
	{
		$BothSpec = new BothSpecification(new TrueSpecification(), new TrueSpecification());
		$this->assertTrue($BothSpec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_fluent_both_spec()
	{
		$Spec = (new TrueSpecification())->both(new TrueSpecification());
		$this->assertTrue($Spec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_chain_several_spec()
	{
		$Spec = (new TrueSpecification())
			->both(new TrueSpecification())
			->either(new FalseSpecification());
		$this->assertTrue($Spec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_Both_Specification_true_and_false_is_false()
	{
		$BothSpec = new BothSpecification(new TrueSpecification(), new FalseSpecification());
		$this->assertFalse($BothSpec->isSatisfiedBy(new MyClass(true)));
		$InvertedSpec = new BothSpecification(new FalseSpecification(), new TrueSpecification());
		$this->assertFalse($InvertedSpec->isSatisfiedBy(new MyClass(true)));
	}
	
	public function test_Both_Specification_false_and_false_is_false()
	{
		$BothSpec = new BothSpecification(new TrueSpecification(), new TrueSpecification());
		$this->assertFalse($BothSpec->isSatisfiedBy(new MyClass(false)));
	}
	
}


?>