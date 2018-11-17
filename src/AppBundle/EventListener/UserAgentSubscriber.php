<?php

namespace AppBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class UserAgentSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->logger->info('JFOPWIJFLWPDOW{P!@#');
        $this->logger->debug($event->getName());
        $request = $event->getRequest();
        $userAgent = $request->headers->get('User-Agent');
        $this->logger->warning("User Agent: $userAgent");
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest'
        ];
    }

}