<?php
namespace GuzzleHttp5\Ring\Future;

/**
 * Future that provides array-like access.
 */
interface FutureArrayInterface extends
    FutureInterface,
    \ArrayAccess,
    \Countable,
    \IteratorAggregate {};
