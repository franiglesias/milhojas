<?php

namespace spec\Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Application\Management\Listener\ReportUnsentPayrolls;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Messaging\EventBus\Listener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class ReportUnsentPayrollsSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $filesystem, Mailer $mailer)
    {
        $this->beConstructedWith($filesystem, $mailer, 'sender@example.com', 'recipient@.example.com', 'template');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ReportUnsentPayrolls::class);
        $this->shouldImplement(Listener::class);
    }

    public function it_handles_all_payrolls_were_sent_event(
        AllPayrollsWereSent $event,
        FilesystemInterface $filesystem,
        PayrollMonth $month,
        Mailer $mailer
    ) {
        $month->getFolderName()->willReturn('2017/03');
        $event->getMonth()->willReturn($month)->shouldBeCalled();
        $filesystem->listContents('new/2017/03')->shouldBeCalled()->willReturn(
            [
                [
                    'path' => 'new/2017/03/example.pdf',
                ],

            ]
        )
        ;
        $filesystem->read('new/2017/03/example.pdf')->shouldBeCalled()->willReturn('content');
        $filesystem->getMimetype('new/2017/03/example.pdf')->shouldBeCalled()->willReturn('application/pdf');
        $mailer->send(Argument::type(MailMessage::class))->shouldBeCalled();
        $this->handle($event);
    }
}
