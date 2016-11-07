<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationSystem;

/**
 *
 */
class EducationSystemTest extends \PHPUnit_Framework_Testcase
{

    public function test_it_has_a_name()
    {
        $system = new EducationSystem('LOMCE');
        $this->assertEquals('LOMCE', $system->getName());
    }

    public function test_it_can_check_equality()
    {
        $system = new EducationSystem('LOMCE');
        $this->assertTrue($system->equals(new EducationSystem('LOMCE')));
    }

    public function test_it_can_check_for_inequality()
    {
        $system = new EducationSystem('LOMCE');
        $this->assertFalse($system->equals(new EducationSystem('LOGSE')));
    }
}

 ?>
