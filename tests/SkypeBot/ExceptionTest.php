<?php

use PHPUnit_Framework_TestCase as TestCase;

class ExceptionTest extends TestCase
{

    function testPayloadException()
    {
        $msg = null;
        try {
            new \SkypeBot\Entity\Jwk\JsonWebKey(new stdClass());
        } catch (\SkypeBot\Exception\PayloadException $ex) {
            $msg = $ex->getMessage();
        }
        $this->assertNotNull($msg);
    }
}