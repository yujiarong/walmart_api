<?php
namespace GuzzleHttp5\Tests\Stream;

use GuzzleHttp5\Stream\InflateStream;
use GuzzleHttp5\Stream\Stream;

class InflateStreamtest extends \PHPUnit_Framework_TestCase
{
    public function testInflatesStreams()
    {
        $content = gzencode('test');
        $a = Stream::factory($content);
        $b = new InflateStream($a);
        $this->assertEquals('test', (string) $b);
    }
}
