<?php

namespace Tests\Library\ValueObjects\Technical;

use Milhojas\Library\ValueObjects\Technical\Ip;

require_once 'exec.php';
/**
* Description
*/
class IpTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_initializes()
	{
		$ip = new Ip('127.0.0.1');
		$this->assertTrue($ip->isUp());
	}

	public function test_it_initializes_with_port()
	{
		$ip = new Ip('127.0.0.1', 80);
		$this->assertTrue($ip->isUp());
		$this->assertTrue($ip->isListening());
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function test_it_fails_if_malformed_ip()
	{
		$ip = new Ip('1270.0.1');
	}

	public function test_is_Down()
	{
		$ip = new Ip('192.168.0.1');
		$this->assertFalse($ip->isUp());
	}
}
?>
