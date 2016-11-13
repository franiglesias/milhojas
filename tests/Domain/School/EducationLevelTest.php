<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

class EducationLevelTest extends \PHPUnit_Framework_Testcase
{
    private $stage;

    public function setUp()
    {
        $system = new EducationSystem(new Name('LOMCE'));
        $this->stage = new EducationStage(
            $system,
            new Name('Primaria'),
            new Name('EP'),
            6);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function test_it_must_belong_to_a_stage()
    {
        $level = new EducationLevel('Stage', 2);
    }

    public function test_it_must_have_short_name()
    {
        $level = new EducationLevel($this->stage, 1);
        $this->assertEquals('EP 1', $level->getShortName());
    }

    public function test_it_must_have_full_name()
    {
        $level = new EducationLevel($this->stage, 2);
        $this->assertEquals('2 Primaria', $level->getFullName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_can_not_set_a_level_greater_than_stage_allows()
    {
        $level = new EducationLevel($this->stage, 7);
    }

    public function test_it_cast_to_string_as_full_name()
    {
        $level = new EducationLevel($this->stage, 2);
        $this->assertEquals('2 Primaria', $level->getFullName());
    }
}
