<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\Subject;

/**
 *
 */
class SubjectTest extends \PHPUnit_Framework_Testcase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_name()
    {
        $subject = new Subject('');
    }

    public function test_it_can_be_optional()
    {
        # code...
    }

    public function test_it_could_be_limited_to_specific_levels_in_stage()
    {
        # code...
    }
}

 ?>
