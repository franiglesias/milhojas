<?php
namespace Tests\Domain\School;

use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationSystem;
/**
 *
 */
class EducationStageTest extends \PHPUnit_Framework_Testcase
{
    private $system;

    public function setUp()
    {
        $this->system = new EducationSystem('LOMCE');
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function test_it_must_belong_to_an_education_system()
    {
        $stage = new EducationStage('A system', 'Educación Infantil', 'EI', 3);
    }

    public function test_it_has_a_name_a_short_name_and_number_of_levels()
    {
        $stage = new EducationStage($this->system, 'Educación Secundaria Obligatoria', 'ESO', 4);
        $this->assertEquals('Educación Secundaria Obligatoria', $stage->getName());
        $this->assertEquals('ESO', $stage->getShortName());
        $this->assertEquals(4, $stage->hasLevels());
    }

    public function test_it_has_a_collection_of_level_objects()
    {
        $stage = new EducationStage($this->system, 'Bachillerato', 'Bach', 2);
        $expected = [new EducationLevel($stage, 1), new EducationLevel($stage, 2)];
        $this->assertEquals($expected, $stage->getLevels());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_short_name()
    {
        $stage = new EducationStage($this->system, 'Bachillerato', 'p', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_valid_name()
    {
        $stage = new EducationStage($this->system, 'Ba', 'Bach', 2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_at_least_a_level()
    {
        $stage = new EducationStage($this->system, 'Bachillerato', 'Bach', 0);
    }

}


 ?>
