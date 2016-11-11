<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\Subject;
use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 * Tests the Subject class.
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

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function test_it_must_belong_to_a_stage()
    {
        $subject = new Subject('Stage', new Name('Francés'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_must_have_a_name()
    {
        $subject = new Subject($this->stage, new Name(''));
    }

    public function test_it_can_be_optional()
    {
        $subject = new Subject($this->stage, new Name('Francés'), true);
        $this->assertTrue($subject->isOptional());
    }

    public function tests_it_has_a_name()
    {
        $subject = new Subject($this->stage, new Name('Science'));
        $this->assertEquals('Science', $subject->getName());
    }

    public function test_it_casts_to_string()
    {
        $subject = new Subject($this->stage, new Name('Science'));
        $this->assertEquals('Science Secundaria (LOMCE)', (string)$subject);
    }

    public function test_it_could_be_limited_to_specific_levels_in_the_stage()
    {
        $subject = new Subject($this->stage, new Name('Cultura Clásica'), false, [3, 4]);
        $this->assertTrue($subject->existsInLevel(3));
        $this->assertFalse($subject->existsInLevel(2));
    }

    public function test_it_can_create_a_course()
    {
        $subject = new Subject($this->stage, new Name('Science'));
        $course = $subject->createCourse(1);
        $this->assertEquals('Science 1 Secundaria (LOMCE)', $course->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_it_can_not_create_a_course_if_invalid_level()
    {
        $subject = new Subject($this->stage, new Name('Cultura Clásica'), false, [3, 4]);
        $course = $subject->createCourse(2);
    }
}
