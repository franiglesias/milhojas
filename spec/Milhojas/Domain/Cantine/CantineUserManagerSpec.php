<?php

namespace spec\Milhojas\Domain\Cantine;

use Milhojas\Domain\Cantine\CantineUserManager;
use Milhojas\Domain\Cantine\RegularCantineUser;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use PhpSpec\ObjectBehavior;

class CantineUserManagerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserManager::class);
    }

    public function it_allows_students_apply_as_Regular(Student $student, MonthWeekSchedule $schedule)
    {
        $student->getStudentId()->willReturn(new StudentId('student-01'));
        $this->applyAsRegular($student, $schedule)->shouldHaveType(RegularCantineUser::class);
    }

    public function it_can_return_a_cantine_user_given_student_id()
    {
        // code...
    }
}
