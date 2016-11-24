<?php

use PHPUnit_Framework_TestCase as TestCase;

class RequestTest extends TestCase
{

    function testConstructor()
    {
        $request = new \SkypeBot\Listener\Request();
        $this->assertEmpty($request->getRawBody());
        $this->assertEmpty($request->getHeaders());
    }
}