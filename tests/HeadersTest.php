<?php namespace Titan\Tests\Http;

use Titan\Http\Headers;
use Titan\Tests\Common\TestCase;

class HeadersTest extends TestCase
{
    private function getInstance()
    {
        return new Headers();
    }

    public function testAppendGetSet()
    {
        $headers = $this->getInstance();
        $headers->set('myKey', 'myValue');
        $headers->append('mykey', 'myAnotherValue');
        $this->assertEquals([
            'myValue',
            'myAnotherValue'
        ], $headers->get('Mykey'));
    }

    public function testLines()
    {
        $headers = $this->getInstance();
        $headers->set('Content-Type', 'application/json');
        $headers->set('Content-Encoding', 'gzip');
        $this->assertEquals([
            'Content-Type: application/json',
            'Content-Encoding: gzip'
        ], $headers->lines());
    }

    public function testFlush()
    {
        $headers = $this->getMockBuilder(Headers::class)->setMethods(['lines', 'clean'])->getMock();
        $headers->expects($this->once())->method('lines')->willReturn([
            'Content-Type: application/json',
            'Content-Encoding: gzip'
        ]);
        $headers->expects($this->once())->method('clean');

        @$headers->flush();
    }
}