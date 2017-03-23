<?php

namespace Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\Event\AllPayrollsWereSent;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Listener;


class ReportUnsentPayrolls implements Listener
{
    /**
     * @var FilesystemInterface
     */
    private $filesystem;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var
     */
    private $sender;
    /**
     * @var
     */
    private $recipient;
    /**
     * @var
     */
    private $template;

    /**
     * ReportUnsentPayrolls constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem, Mailer $mailer, $sender, $recipient, $template)
    {
        $this->filesystem = $filesystem;
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->template = $template;
    }


    /**
     * @param AllPayrollsWereSent $event
     */
    public function handle(Event $event)
    {

        $path = sprintf('new/%s', $event->getMonth()->getFolderName());
        $pending = $this->filesystem->listContents($path);


        $message = new MailMessage();
        $message
            ->setTo($this->recipient)
            ->setSender($this->sender)
            ->setTemplate(
                $this->template,
                [
                    'month' => $event->getMonth(),
                ]
            )
        ;
        foreach ($pending as $file) {
            $message->attach(
                [
                    'data' => $this->filesystem->read($file['path']),
                    'type' => $this->filesystem->getMimetype($file['path']),
                    'filename' => basename($file['path']),
                ]
            );
        }


        $this->mailer->send($message);

    }
}
