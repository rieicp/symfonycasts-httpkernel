<?php

namespace AppBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

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

//        if (rand(0,100) > 50) {
//            $response = new Response('Come back later!');
//            $event->setResponse($response);
//        }

//        $request->attributes->set('_controller', function($id){
//            return new Response('Hello '.$id);
//        });

        $isMac = stripos($userAgent, 'mac') !== false;
        $request->attributes->set('isMac', $isMac);
    }

    public static function getSubscribedEvents()
    {
        return [
            //'kernel.request' == KernelEvents::REQUEST
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

}