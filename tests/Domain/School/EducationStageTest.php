<?php
namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationLevel;
/**
 *
 */
class EducationStageTest extends \PHPUnit_Framework_Testcase
{

    public function test_it_has_a_name_a_short_name_and_number_of_levels()
    {
        $stage = new EducationStage('Educación Secundaria Obligatoria', 'ESO', 4);
        $this->assertEquals('Educación Secundaria Obligatoria', $stage->getName());
        $this->assertEquals('ESO', $stage->getShortName());
        $this->assertEquals(4, $stage->hasLevels());
    }

    public function test_it_has_a_collection_of_level_objects()
    {
        $stage = new EducationStage('Bachillerato', 'Bach', 2);
        $expected = [new EducationLevel($stage, 1), new EducationLevel($stage, 2)];
        $this->assertEquals($expected, $stage->getLevels());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_short_name()
    {
        $stage = new EducationStage('Bachillerato', 'pr', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_valid_name()
    {
        $stage = new EducationStage('C', 'Bach', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_at_least_a_level()
    {
        $stage = new EducationStage('Bachillerato', 'Bach', 0);
    }
}


 ?>
