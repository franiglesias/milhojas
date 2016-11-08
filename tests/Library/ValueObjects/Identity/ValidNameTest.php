<?php

namespace Tests\Library\ValueObjects\Identity;
use Milhojas\Library\ValueObjects\Identity\ValidName;

/**
 * A class to Test ValidName
 */
class ValidNameTest extends \PHPUnit_Framework_Testcase
{
    public function test_it_is_valid_if_has_minimum_lenght()
    {
        $aName = new ValidName('A long name');
        $this->assertEquals('A long name', $aName->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_fails_is_name_is_not_valid()
    {
        $aName = new ValidName('nv');
    }
}


 ?>
