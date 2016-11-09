<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

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
        $system->addStage(new Name('Infantil'), new Name('EI'), 3);
        $system->addStage(new Name('Primary'), new Name('EP'), 6);
        $this->assertEquals(2, $system->hasStages());
    }

    public function test_it_can_add_one_or_more_subjects_to_a_stage()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $system->addStage(new Name('Infantil'), new Name('EI'), 3);
        $system->addSubject(new Name('EI'), new Name('Matemátcas'));
    }

    public function test_it_can_not_add_the_same_stage_twice()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $system->addStage(new Name('Infantil'), new Name('EI'), 3);
        $system->addStage(new Name('Infantil'), new Name('EI'), 3);
        $this->assertEquals(1, $system->hasStages());
    }
}
