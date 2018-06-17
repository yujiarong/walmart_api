<?php
namespace GuzzleHttp5\Tests\Stream\Exception;

use GuzzleHttp5\Stream\Exception\SeekException;
use GuzzleHttp5\Stream\Stream;

class SeekExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasStream()
    {
        $s = Stream::factory('foo');
        $e = new SeekException($s, 10);
        $this->assertSame($s, $e->getStream());
        $this->assertContains('10', $e->getMessage());
    }
}
