<?php

namespace spec\Milhojas\Domain\Extracurricular;

use Milhojas\Domain\Extracurricular\ActivityRepository;
use Milhojas\Domain\Extracurricular\ActivitiesUser;
use Milhojas\Domain\Extracurricular\ExtracurricularManager;
use Milhojas\Domain\Extracurricular\Specification\ActivityHasName;
use Milhojas\Domain\Extracurricular\Activity;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtracurricularManagerSpec extends ObjectBehavior
{
    public function let(ActivityRepository $activityRepository)
    {
        $this->beConstructedWith($activityRepository);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(ExtracurricularManager::class);
    }

    public function it_can_enroll_student_to_activity(ActivitiesUser $user, Activity $activity, $activityRepository)
    {
        $activityRepository->get(Argument::type(ActivityHasName::class))->shouldBeCalled()->willReturn($activity);
        $user->enrollTo(Argument::type(Activity::class))->shouldBeCalled();
        $this->enrollStudent($user, 'Activity');
    }
}
