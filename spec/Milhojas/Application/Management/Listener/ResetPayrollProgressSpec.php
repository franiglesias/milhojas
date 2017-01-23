<?php

namespace spec\Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Listener\ResetPayrollProgress;
use PhpSpec\ObjectBehavior;

class ResetPayrollProgressSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $fs)
    {
        $this->beConstructedWith('management-payroll-reporter.json', $fs);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ResetPayrollProgress::class);
    }

    public function it_handles_AllPayrollsWereSent_event(AllPayrollsWereSent $event, $fs)
    {
        $fs->put('management-payroll-reporter.json', '')->shouldBeCalled();
        $this->handle($event);
    }
}
