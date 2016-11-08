<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 *
 */
class EducationSystemTest extends \PHPUnit_Framework_Testcase
{

    public function test_it_has_a_name()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $this->assertEquals('LOMCE', $system->getName());
    }

    public function test_it_can_check_equality()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $this->assertTrue($system->equals(new EducationSystem(new Name('LOMCE'))));
    }

    public function test_it_can_check_for_inequality()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $this->assertFalse($system->equals(new EducationSystem(new Name('LOGSE'))));
    }

    public function test_it_can_hold_one_or_more_stages()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $system->addStage('Infantil', 'EI', 3);
        $system->addStage('Primary', 'EP', 6);
        $this->assertEquals(2, $system->hasStages());
    }
}

 ?>
