<?php

namespace Tests\Library\ValueObjects\Identity;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * A class to Test Name
 */
class NameTest extends \PHPUnit_Framework_Testcase
{
    public function test_it_is_valid_if_has_minimum_lenght()
    {
        $aName = new Name('A long name');
        $this->assertEquals('A long name', $aName->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_fails_is_name_is_not_valid()
    {
        $aName = new Name('nv');
    }

    public function test_it_can_be_used_as_string()
    {
        $aName = new Name('A long name');
        $this->assertEquals('A long name', (string)$aName);
    }
}


 ?>
