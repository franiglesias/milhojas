<?php

namespace Milhojas\Application\Management\Listener;

use League\Flysystem\FilesystemInterface;
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Reporter\EmailReporter;

class PayrollSendingCompleteReporter extends EmailReporter
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var FilesystemInterface
     */
    private $fs;
    /**
     * @var EmailReporter
     */
    private $reporter;

    /**
     * @param string              $file
     * @param FilesystemInterface $fs
     * @param Mailer              $mailer
     * @param string              $sender
     * @param string              $recipient
     * @param string              $template
     */
    public function __construct(
        $file,
        FilesystemInterface $fs,
        Mailer $mailer,
        $sender,
        $recipient,
        $template
    ) {
        $this->file = $file;
        $this->fs = $fs;
        parent::__construct($mailer, $sender, $recipient, $template);
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareTemplateParameters(Event $event)
    {
        return array(
                'month' => $event->getMonth(),
                'sent' => $event->getCurrentProgress(),
                'total' => $event->getTotalProgress(),
                'employees' => $event->getTotalProgress(),
                'ok' => $event->getSentProgress(),
                'not_found' => $event->getNotFoundProgress(),
                'failed' => $event->getFailedProgress(),
                'not_found_list' => $this->fs->readAndDelete($this->file),
            );
    }
}
