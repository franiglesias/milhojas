<?php

namespace Milhojas\Application\Contents\Projector;

use Milhojas\Library\Messaging\EventBus\Event;
use Milhojas\Library\Messaging\EventBus\Listener;
use Doctrine\ORM\EntityManager;
use Milhojas\Domain\Contents\DTO\PostList;

class PostListProjector implements Listener
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function handle(Event $event)
    {
        $postList = $this->em->getRepository('Contents:PostList')->find($event->getId());
        if (!$postList) {
            $postList = new PostList($event->getId(), $event->getTitle());
            $this->em->persist($postList);
        } else {
            $postList->setTitle($event->getTitle());
        }
        $this->em->flush();
    }
}
