<?php
namespace Walmart\middleware;

use GuzzleHttp5\Event\CompleteEvent;
use GuzzleHttp5\Event\RequestEvents;
use GuzzleHttp5\Event\SubscriberInterface;
use GuzzleHttp5\Stream\Stream;
use Walmart\Utils;

class XmlNamespaceSubscriber implements SubscriberInterface
{
    public function getEvents()
    {
        return [
            // need to attach after response
            'complete' => ['stripXmlNamespaces', RequestEvents::VERIFY_RESPONSE - 1],
        ];
    }

    public function stripXmlNamespaces(CompleteEvent $event)
    {
        /**
         * Parsing XML with namespaces doesn't seem to work for Guzzle,
         * so using regex to remove them.
         */
        $xml = $event->getResponse()->getBody()->getContents();
        $xml = Utils::stripNamespacesFromXml($xml);

        /**
         * Intercept response and replace body with cleaned up XML
         */
        $stream = Stream::factory($xml);
        $response = $event->getResponse();
        $response->setBody($stream);
        $event->intercept($response);
    }

}