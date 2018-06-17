<?php
namespace GuzzleHttp5\Subscriber;

use GuzzleHttp5\Event\CompleteEvent;
use GuzzleHttp5\Event\RequestEvents;
use GuzzleHttp5\Event\SubscriberInterface;
use GuzzleHttp5\Exception\RequestException;

/**
 * Throws exceptions when a 4xx or 5xx response is received
 */
class HttpError implements SubscriberInterface
{
    public function getEvents()
    {
        return ['complete' => ['onComplete', RequestEvents::VERIFY_RESPONSE]];
    }

    /**
     * Throw a RequestException on an HTTP protocol error
     *
     * @param CompleteEvent $event Emitted event
     * @throws RequestException
     */
    public function onComplete(CompleteEvent $event)
    {
        $code = (string) $event->getResponse()->getStatusCode();
        // Throw an exception for an unsuccessful response
        if ($code[0] >= 4) {
            throw RequestException::create(
                $event->getRequest(),
                $event->getResponse()
            );
        }
    }
}
