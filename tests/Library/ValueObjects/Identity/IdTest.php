<?php

namespace Tests\Library\ValueObjects\Identity;

use Milhojas\Library\ValueObjects\Identity\Id;

/**
* Description
*/
class IdTest extends \PHPUnit_Framework_TestCase
{
	public function test_it_can_create_an_id()
	{
		$Id = Id::create();
		$this->assertInstanceOf('Milhojas\Library\ValueObjects\Identity\Id', $Id);
	}
}
?>
