<?php

namespace spec\Milhojas\Domain\School;

use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\School\StudentGroup;
use Milhojas\Domain\School\NewStudentGroup;
use Milhojas\Domain\Cantine\Allergens;
use Milhojas\Library\ValueObjects\Identity\PersonName;
use PhpSpec\ObjectBehavior;

class StudentSpec extends ObjectBehavior
{
    public function let(StudentId $studentId, PersonName $personName, Allergens $allergens)
    {
        $this->beConstructedWith($studentId, $personName, $allergens);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Student::class);
    }

    public function it_has_a_name($personName)
    {
        $this->getName()->shouldBe($personName);
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

    public function it_can_tell_its_allergens($allergens)
    {
        $this->getAllergies()->shouldBe($allergens);
    }
}
