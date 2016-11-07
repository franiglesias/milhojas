<?php


namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationStage;

/**
 *
 */
class EducationLevelTest extends \PHPUnit_Framework_Testcase
{
    public function test_it_must_have_short_name()
    {
        $stage = new EducationStage('Primaria', 'EP', 6);
        $level = new EducationLevel($stage, 1);
        $this->assertEquals('EP 1', $level->getShortName());
    }

    public function test_it_must_have_full_name()
    {
        $stage = new EducationStage('Primaria', 'EP', 6);
        $level = new EducationLevel($stage, 2);
        $this->assertEquals('2 Primaria', $level->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_can_not_set_a_level_greater_than_stage_allows()
    {
        $stage = new EducationStage('Primaria', 'EP', 6);
        $level = new EducationLevel($stage, 7);
    }

}


 ?>
