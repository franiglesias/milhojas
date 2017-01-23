<?php

namespace spec\Milhojas\Application\Management\Reporter;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\PayrollEmailWasSent;
use Milhojas\Application\Management\Event\PayrollCouldNotBeFound;
use Milhojas\Application\Management\Event\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Reporter\PayrollProgressReporter;
use PhpSpec\ObjectBehavior;

class PayrollProgressReporterSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $fs)
    {
        $this->beConstructedWith('management-payroll-reporter.json', $fs);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(PayrollProgressReporter::class);
    }

    public function it_handles_PayrollEmailWasSent_event(PayrollEmailWasSent $event, $fs)
    {
        $event->getProgressDataAsJson()->shouldBeCalled()->willReturn('somedata');
        $fs->put('management-payroll-reporter.json', 'somedata')->shouldBeCalled();
        $this->handle($event);
    }

    public function it_handles_PayrollEmailCouldNotBeSent_event(PayrollEmailCouldNotBeSent $event, $fs)
    {
        $event->getProgressDataAsJson()->shouldBeCalled()->willReturn('somedata');
        $fs->put('management-payroll-reporter.json', 'somedata')->shouldBeCalled();
        $this->handle($event);
    }

    public function it_handles_PayrollCouldNotBeFound_event(PayrollCouldNotBeFound $event, $fs)
    {
        $event->getProgressDataAsJson()->shouldBeCalled()->willReturn('somedata');
        $fs->put('management-payroll-reporter.json', 'somedata')->shouldBeCalled();
        $this->handle($event);
    }
}
