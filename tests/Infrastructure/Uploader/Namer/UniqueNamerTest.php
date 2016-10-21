<?php

namespace Tests\Infrastructure\Uploader\Namer;

use Milhojas\Infrastructure\Uploader\Namer\UniqueNamer;

class RandomGenerator {
	public function get()
	{
		return 'a-random-string';
	}
}
/**
* Description
*/
class UniqueNamerTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_creates_unique_name()
	{
		$namer = new UniqueNamer(new RandomGenerator());
		$this->assertEquals('a-random-string', $namer->make());
	}
}

?>
