<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 20/3/17
 * Time: 17:09
 */

namespace Milhojas\Application\Management\Listener;


use Milhojas\Messaging\EventBus\Event;
use Milhojas\Messaging\EventBus\Listener;
use Psr\Log\LoggerInterface;


class LogPayrollEvent implements Listener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogPayrollEvent constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Event $event)
    {
        $this->logger->notice($event, ['listener']):
    }
}
