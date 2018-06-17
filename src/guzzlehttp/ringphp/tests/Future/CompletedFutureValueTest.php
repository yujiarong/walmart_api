<?php
namespace GuzzleHttp5\Tests\Ring\Future;

use GuzzleHttp5\Ring\Exception\CancelledFutureAccessException;
use GuzzleHttp5\Ring\Future\CompletedFutureValue;

class CompletedFutureValueTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsValue()
    {
        $f = new CompletedFutureValue('hi');
        $this->assertEquals('hi', $f->wait());
        $f->cancel();

        $a = null;
        $f->then(function ($v) use (&$a) {
            $a = $v;
        });
        $this->assertSame('hi', $a);
    }

    public function testThrows()
    {
        $ex = new \Exception('foo');
        $f = new CompletedFutureValue(null, $ex);
        $f->cancel();
        try {
            $f->wait();
            $this->fail('did not throw');
        } catch (\Exception $e) {
            $this->assertSame($e, $ex);
        }
    }

    public function testMarksAsCancelled()
    {
        $ex = new CancelledFutureAccessException();
        $f = new CompletedFutureValue(null, $ex);
        try {
            $f->wait();
            $this->fail('did not throw');
        } catch (\Exception $e) {
            $this->assertSame($e, $ex);
        }
    }
}
