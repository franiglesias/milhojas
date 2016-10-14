<?php

namespace Tests\Milhojas\Library\ValueObjects\Identity;

use Milhojas\Library\ValueObjects\Identity\Username;

/**
* Description
*/
class UsernameTest extends \PHPUnit_Framework_Testcase
{
	public function testItCanCreateUsername()
	{
		$UserName = new Username('frankie@miralba.org');
		$this->assertEquals('frankie@miralba.org', $UserName->get());
	}
	
	public function testItCanReturnDomain()
	{
		$UserName = new Username('frankie@miralba.org');
		$this->assertEquals('miralba.org', $UserName->getDomain());
		
		$UserName = new Username('frankie');
		$this->assertEquals(null, $UserName->getDomain());
	}
	
	public function testItKnowsIfBelongsToADomain()
	{
		$UserName = new Username('frankie@miralba.org');
		$this->assertTrue($UserName->belongsToDomain('miralba.org'));
		$this->assertFalse($UserName->belongsToDomain('google.com'));
	}
}

?>
