<?php

namespace App\EventSubscriber;

use DateTime;
use App\Entity\Webhook;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HttpSubscriber implements EventSubscriberInterface
{

    /**
     * @var Webhook
     */
    private $webhook;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->webhook = new Webhook();

        $this->webhook->setCreatedAt(new DateTime());

        $this->webhook->setQuery($event->getRequest()->query->all());
        $this->webhook->setServer($event->getRequest()->server->all());
        $this->webhook->setHeaders($event->getRequest()->headers->all());
        $this->webhook->setRequest($event->getRequest()->request->all());

        $this->webhook->setJson(json_decode($event->getRequest()->getContent(), true));
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $this->webhook->setResponse($event->getResponse());
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $this->webhook->setException($event->getThrowable()->getTraceAsString());

        $event->setResponse(new JsonResponse([
            'status' => $event->getThrowable()->getCode(),
            'message' => $event->getThrowable()->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }

    public function onKernelTerminate(TerminateEvent $event)
    {
        $this->entityManager->persist($this->webhook);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::RESPONSE => 'onKernelResponse',
            KernelEvents::EXCEPTION => 'onKernelException',
            KernelEvents::TERMINATE => 'onKernelTerminate'
        ];
    }
}
