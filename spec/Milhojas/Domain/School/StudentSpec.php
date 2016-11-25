<?php

namespace spec\Milhojas\Domain\School;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\School\StudentGroup;
use Milhojas\Domain\School\NewStudentGroup;
use PhpSpec\ObjectBehavior;

class StudentSpec extends ObjectBehavior
{
    public function let(StudentId $studentId)
    {
        $this->beConstructedWith($studentId);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Student::class);
    }

    public function it_belongs_to_self_assigned_group()
    {
        $this->getGroup()->shouldHaveType(NewStudentGroup::class);
    }

    public function it_can_get_StudentId($studentId)
    {
        $this->getStudentId()->shouldHaveType(StudentId::class);
        $this->getStudentId()->shouldBe($studentId);
    }

    public function it_can_tell_group_student_belongs()
    {
        $this->getGroup()->shouldHaveType(StudentGroup::class);
    }

    public function it_can_be_assigned_to_a_group(StudentGroup $studentGroup)
    {
        $this->assignGroup($studentGroup);
        $this->getGroup()->shouldBeLike($studentGroup);
    }
}