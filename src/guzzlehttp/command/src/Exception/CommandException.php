<?php
namespace GuzzleHttp5\Command\Exception;

use GuzzleHttp5\Command\CommandTransaction;
use GuzzleHttp5\Exception\RequestException;
use GuzzleHttp5\Command\ServiceClientInterface;
use GuzzleHttp5\Command\CommandInterface;
use GuzzleHttp5\Collection;
use GuzzleHttp5\Message\Request;

/**
 * Exception encountered while transferring a command.
 */
class CommandException extends RequestException
{
    /** @var CommandTransaction */
    private $trans;

    /**
     * @param string             $message  Exception message
     * @param CommandTransaction $trans    Contextual transfer information
     * @param \Exception         $previous Previous exception (if any)
     */
    public function __construct(
        $message,
        CommandTransaction $trans,
        \Exception $previous = null
    ) {
        $this->trans = $trans;
        $request = $trans->request ?: new Request(null, null);
        $response = $trans->response;
        parent::__construct($message, $request, $response, $previous);
    }

    /**
     * Gets the service client associated with the failed command.
     *
     * @return ServiceClientInterface
     */
    public function getClient()
    {
        return $this->trans->serviceClient;
    }

    /**
     * Gets the command that failed.
     *
     * @return CommandInterface
     */
    public function getCommand()
    {
        return $this->trans->command;
    }

    /**
     * Gets the result of the command if a result was set.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->trans->result;
    }

    /**
     * Gets the context of the command as a collection.
     *
     * @return Collection
     */
    public function getContext()
    {
        return $this->trans->context;
    }

    /**
     * Gets the transaction associated with the exception.
     *
     * @return CommandTransaction
     */
    public function getTransaction()
    {
        return $this->trans;
    }
}
