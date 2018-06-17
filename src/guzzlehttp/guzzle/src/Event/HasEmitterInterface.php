<?php
namespace GuzzleHttp5\Event;

/**
 * Holds an event emitter
 */
interface HasEmitterInterface
{
    /**
     * Get the event emitter of the object
     *
     * @return EmitterInterface
     */
    public function getEmitter();
}
