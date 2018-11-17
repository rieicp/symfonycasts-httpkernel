<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserAgentSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest()
    {
        die('it works!');
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
            'kernel.request' => 'onKernelRequest'
        ];
    }

}