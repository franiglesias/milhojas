<?php

namespace spec\Milhojas\Library\ValueObjects\Dates;

use Milhojas\Library\ValueObjects\Dates\MonthYear;
use PhpSpec\ObjectBehavior;

class MonthYearSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(MonthYear::class);
    }

    public function it_can_be_defined_from_current_date()
    {
        $current = new \DateTime();
        $expected = $current->format('m/Y');
        $this->beConstructedThrough('current');
        $this->asString()->shouldBe($expected);
    }

    public function it_can_be_defined_from_arbitrary_date()
    {
        $this->beConstructedThrough('fromDate', [new \DateTime('11/15/2016')]);
        $this->asString()->shouldBe('11/2016');
    }

    public function it_can_be_defined_by_month_year()
    {
        $this->beConstructedThrough('create', ['november', '2016']);
        $this->asString()->shouldBe('11/2016');
    }

    public function it_can_be_defined_by_numeric_month_year()
    {
        $this->beConstructedThrough('create', ['11', '2016']);
        $this->asString()->shouldBe('11/2016');
    }

    public function it_can_be_defined_by_short_year()
    {
        $this->beConstructedThrough('create', ['11', '16']);
        $this->asString()->shouldBe('11/2016');
    }
}
