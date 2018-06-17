<?php
namespace GuzzleHttp\Command\Guzzle\RequestLocation;

use GuzzleHttp5\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\Parameter;
use GuzzleHttp5\Message\RequestInterface;
use GuzzleHttp5\Stream\Stream;

/**
 * Adds a body to a request
 */
class BodyLocation extends AbstractLocation
{
    public function visit(
        CommandInterface $command,
        RequestInterface $request,
        Parameter $param,
        array $context
    ) {
        $value = $command[$param->getName()];
        $request->setBody(Stream::factory($param->filter($value)));
    }
}
