<?php
namespace GuzzleHttp\Command\Guzzle\ResponseLocation;

use GuzzleHttp\Command\Guzzle\Parameter;
use GuzzleHttp5\Message\ResponseInterface;
use GuzzleHttp5\Command\CommandInterface;

/**
 * Extracts headers from the response into a result fields
 */
class HeaderLocation extends AbstractLocation
{
    public function visit(
        CommandInterface $command,
        ResponseInterface $response,
        Parameter $param,
        &$result,
        array $context = []
    ) {
        // Retrieving a single header by name
        $name = $param->getName();
        if ($header = $response->getHeader($param->getWireName())) {
            $result[$name] = $param->filter($header);
        }
    }
}
