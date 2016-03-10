<?php

namespace Tests\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\Ip;


/**
* Description
*/
class IpTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_initializes()
	{
		$ip = new Ip('127.0.0.1', 80);
		$this->assertTrue($ip->isUp());
		$this->assertTrue($ip->isListening());
	}
}
?>