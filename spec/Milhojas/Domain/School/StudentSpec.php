<?php

namespace spec\Milhojas\Domain\School;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StudentSpec extends ObjectBehavior
{
    public function let(StudentId $studentId)
    {
        $this->beConstructedWith($studentId);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Student::class);
    }

    public function it_can_get_StudentId($studentId)
    {
        $this->getStudentId()->shouldHaveType(StudentId::class);
        $this->getStudentId()->shouldBe($studentId);
    }
}
