<?php

namespace spec\Milhojas\Infrastructure\Persistence\Extracurricular;

use Milhojas\Domain\Extracurricular\Activity;
use Milhojas\Domain\Extracurricular\ActivityRepository;
use Milhojas\Infrastructure\Persistence\Extracurricular\ActivityInMemoryRepository;
use PhpSpec\ObjectBehavior;

class ActivityInMemoryRepositorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ActivityInMemoryRepository::class);
        $this->shouldImplement(ActivityRepository::class);
    }

    public function it_stores_activities(Activity $activity)
    {
        $this->store($activity);
        $this->count()->shouldBe(1);
    }
}
