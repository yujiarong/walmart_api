<?php
namespace GuzzleHttp\Command\Guzzle\ResponseLocation;

use GuzzleHttp\Command\Guzzle\Parameter;
use GuzzleHttp5\Message\ResponseInterface;
use GuzzleHttp5\Command\CommandInterface;

/**
 * Extracts the body of a response into a result field
 */
class BodyLocation extends AbstractLocation
{
    public function visit(
        CommandInterface $command,
        ResponseInterface $response,
        Parameter $param,
        &$result,
        array $context = []
    ) {
        $result[$param->getName()] = $param->filter($response->getBody());
    }
}
