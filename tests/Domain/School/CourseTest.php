<?php

namespace Tests\Domain\School;

use Milhojas\Domain\School\Course;
use Milhojas\Domain\School\Subject;
use Milhojas\Domain\School\EducationLevel;
use Milhojas\Domain\School\EducationStage;
use Milhojas\Domain\School\EducationSystem;
use Milhojas\Library\ValueObjects\Identity\Name;

/**
 *
 */
class CourseTest extends \PHPUnit_Framework_Testcase
{
  private $subject;

  public function setUp()
  {
      $system = new EducationSystem(new Name ('LOMCE'));
      $stage = new EducationStage($system, new Name('Secundaria'), new Name('ESO'), 4);
      $this->subject = new Subject($stage, new Name('Matemáticas'));
  }

  public function test_given_a_subject_creates_a_course()
  {
    $course = new Course($this->subject, new EducationLevel($this->subject->getStage(), 1));
    $this->assertEquals('Matemáticas 1 Secundaria (LOMCE)', $course->getName(), "message");
  }
}

?>
