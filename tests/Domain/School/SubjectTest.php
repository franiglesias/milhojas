<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\Subject;
use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 *
 */
class SubjectTest extends \PHPUnit_Framework_Testcase
{
    private $stage;

    public function setUp()
    {
        $this->stage = new EducationStage(
            new EducationSystem(new Name('LOMCE')),
            new Name('Secundaria'),
            new Name('ESO'),
            4);
    }

    public function test_it_must_belong_to_stage()
    {
    # code...
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_name()
    {
        $subject = new Subject(new Name(''));
    }

    public function test_it_can_be_optional()
    {
        $subject = new Subject(new Name('Francés') , true);
        $this->assertTrue($subject->isOptional());
    }

    public function tests_it_has_a_name()
    {
        $subject = new Subject(new Name('Science'));
        $this->assertEquals('Science', $subject->getName());
    }

    public function test_it_could_be_limited_to_specific_levels_in_stage()
    {
        $subject = new Subject(new Name('Cultura Clásica'), false, [3, 4]);
        $this->assertTrue($subject->existsInLevel(3));
        $this->assertFalse($subject->existsInLevel(2));

    }
}

 ?>
