<?php

namespace spec\Milhojas\Domain\Cantine\Specification;

use Milhojas\Domain\Cantine\Specification\AssociatedCantineUser;
use Milhojas\Domain\Cantine\Specification\CantineUserSpecification;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;

class AssociatedCantineUserSpec extends ObjectBehavior
{
    public function let(Student $student)
    {
        $student->getStudentId()->willReturn(new StudentId('student-01'));
        $this->beConstructedWith($student);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(AssociatedCantineUser::class);
        $this->shouldImplement(CantineUserSpecification::class);
    }

    public function it_should_be_satisfied_by_cantine_user_associated(CantineUser $user, $student)
    {
        $user->getStudentId()->willReturn(new StudentId('student-01'));
        $this->shouldBeSatisfiedBy($user);
    }

    public function it_should_not_be_satisfied_by_cantine_user_associated(CantineUser $user, $student)
    {
        $user->getStudentId()->willReturn(new StudentId('student-02'));
        $this->shouldNotBeSatisfiedBy($user);
    }
}
