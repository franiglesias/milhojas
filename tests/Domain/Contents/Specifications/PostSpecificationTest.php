<?php

namespace Test\Domain\Contents\Specifications;

use Domain\Contents\Specifications\PostSpecificationInterface;

class PostSpecificacion implements PostSpecificationInterface {
	public function isSatisfiedBy(\Domain\Contents\Post $Post)
	{
		
	}
}


class PostSpecificationTest extends \PHPUnit_Framework_Testcase {
	
	public function test_can_create_a_specification()
	{
		# code...
	}
}
?>