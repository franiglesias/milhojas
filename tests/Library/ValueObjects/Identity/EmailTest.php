<?php

namespace Tests\Milhojas\Library\ValueObjects\Identity;

use Milhojas\Library\ValueObjects\Identity\Email;

/**
* Description
*/
class EmailTest extends \PHPUnit_Framework_Testcase
{
	public function testItCanCreateEmail()
	{
		$UserName = new Email('frankie@miralba.org');
		$this->assertEquals('frankie@miralba.org', $UserName->get());
	}
	
	public function testItCanReturnDomain()
	{
		$UserName = new Email('frankie@miralba.org');
		$this->assertEquals('miralba.org', $UserName->getDomain());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 *
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	public function testItDoesNotAllowMalformedEmail()
	{
		$UserName = new Email('frankie');
	}
	
	public function testItKnowsIfBelongsToADomain()
	{
		$UserName = new Email('frankie@miralba.org');
		$this->assertTrue($UserName->belongsToDomain('miralba.org'));
		$this->assertFalse($UserName->belongsToDomain('google.com'));
	}
}

?>
