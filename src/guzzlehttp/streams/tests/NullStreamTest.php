<?php
namespace GuzzleHttp5\Tests\Stream;

use GuzzleHttp5\Stream\NullStream;

class NullStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testDoesNothing()
    {
        $b = new NullStream();
        $this->assertEquals('', $b->read(10));
        $this->assertEquals(4, $b->write('test'));
        $this->assertEquals('', (string) $b);
        $this->assertNull($b->getMetadata('a'));
        $this->assertEquals([], $b->getMetadata());
        $this->assertEquals(0, $b->getSize());
        $this->assertEquals('', $b->getContents());
        $this->assertEquals(0, $b->tell());

        $this->assertTrue($b->isReadable());
        $this->assertTrue($b->isWritable());
        $this->assertTrue($b->isSeekable());
        $this->assertFalse($b->seek(10));

        $this->assertTrue($b->eof());
        $b->detach();
        $this->assertTrue($b->eof());
        $b->close();
    }

    /**
     * @expectedException \GuzzleHttp5\Stream\Exception\CannotAttachException
     */
    public function testCannotAttach()
    {
        $p = new NullStream();
        $p->attach('a');
    }
}
