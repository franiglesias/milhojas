<?php

namespace spec\Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Listener\PayrollSendingCompleteReporter;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Messaging\EventBus\Reporter\EmailReporter;
use PhpSpec\ObjectBehavior;

class PayrollSendingCompleteReporterSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $fs, Mailer $mailer)
    {
        $this->beConstructedWith('no-payroll-found.data', $fs, $mailer, 'from@example.com', 'to@example.com', 'template');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(PayrollSendingCompleteReporter::class);
        $this->shouldBeAnInstanceOf(EmailReporter::class);
    }

    public function it_appends_data_from_file_to_template_parameters($fs, $reporter, AllPayrollsWereSent $event)
    {
        $fs->readAndDelete('no-payroll-found.data')->shouldBeCalled();
        $this->handle($event);
    }
}
