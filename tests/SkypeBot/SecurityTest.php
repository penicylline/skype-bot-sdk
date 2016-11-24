<?php

use PHPUnit_Framework_TestCase as TestCase;

class SecurityTest extends TestCase
{
    /**
     * @var \SkypeBot\SkypeBot
     */
    private $bot;

    public function setUp()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $storage = new \SkypeBot\Storage\MemoryStorage();
        $this->bot = \SkypeBot\SkypeBot::init($config, $storage);

        $k = new stdClass();
        $k->kty = 'RSA';
        $k->use = 'sig';
        $k->kid = 'aaa';
        $k->x5t = 'aaa';
        $k->n = 'bbb';
        $k->e = 'AQAB';
        $k->x5c = ['MIIB0zCCAX2gAwIBAgIJAI3IleFgCVOrMA0GCSqGSIb3DQEBCwUAMEUxCzAJBgNVBAYTAkFVMRMwEQYDVQQIDApTb21lLVN0YXRlMSEwHwYDVQQKDBhJbnRlcm5ldCBXaWRnaXRzIFB0eSBMdGQwHhcNMTYxMTI0MTAwMTMyWhcNMTcxMTI0MTAwMTMyWjBFMQswCQYDVQQGEwJBVTETMBEGA1UECAwKU29tZS1TdGF0ZTEhMB8GA1UECgwYSW50ZXJuZXQgV2lkZ2l0cyBQdHkgTHRkMFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBALcrQ09cMPoQbi4pWhNgo88G7HnaYJaDp38w/cvHUC+qdHPSPmKK0EeJjj1PtbJvJucYRlruJvTwjmB+YXM+uTsCAwEAAaNQME4wHQYDVR0OBBYEFAJk3IpUH8iwul2rpV6ciWTNc1cwMB8GA1UdIwQYMBaAFAJk3IpUH8iwul2rpV6ciWTNc1cwMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQELBQADQQAMKN/HpL0NVQqPfGAfnO27cOK4qouP6/o62PhuqNZHsAt9dFqTaW9baj5d3NuNwLz8Cye/afAmYLLcdiQz6AFL'];

        $key = new \SkypeBot\Entity\JsonWebKey($k);

        $keys = $this->getMockBuilder('\\SkypeBot\\DataProvider\\OpenIdKeysProvider')
            ->disableOriginalConstructor()
            ->getMock();
        $keys->expects($this->any())
            ->method('getKeyById')
            ->will($this->returnValue($key));
        $this->bot->set('openid_keys', $keys);
    }

    function testConstructor()
    {
        $this->bot->set('',null);
        $security = new \SkypeBot\Listener\Security();
        $res = $security->validateBearerHeader('Bearer ' . $this->buildToken());
        $this->assertEquals(1, $res);
    }

    private function buildToken()
    {
        $payload = base64_encode('
        {
            "iss":"1",
            "aud":"2",
            "exp": '. (time() + 99999999) .',
            "nbf":"1"
        }
        ');
        $info = base64_encode('
        {
            "typ":"1",
            "alg":"RS256",
            "kid":"3",
            "x5t":"4"
        }
        ');
        $data = $info . '.' . $payload;
        $pkey = openssl_pkey_get_private('-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIgYPeieA1PasCAggA
MBQGCCqGSIb3DQMHBAhOIn83Un7MVgSCAWDCvEo4LoeyXLsg3L01qlJTnC9R9DYF
yv2paxh8ejtnP+hvcycG1DjRj4oj2SpbRDomBoM06iAUrkg0BOKo8LYKV4dAUE8Q
V2mH3tZm+qRURfDpI9ieZFl3iRb7cPNK/tXjQSt8BlETtCR59gassmMH5M443h6D
ar/DCdoTw9nHc1U6ATN4mTmrnZXQ+vwEvPyvy5X/gk8A3ZZg5dVtRSpgSIw5ZS7L
RaU+37Ag9RB5zKZpMxS6OTqDCginQ7Ii585DsQ7aX0IxuP72VDywa8Edn130JPUU
IgDFi1w/p5nQ49cBlRZei5UP2OrDsSr4k6CGrqs6j/+COBWvgoz4Br/XU7NVzUHs
wmMuZ7B6UoumJY9cMW1obfaXmD+GOXny4TsZni8L8+wo0AdM3S8hP7i48wgGL9jE
M8Sb+LtG4UvbOTi+nzpdD0Z7TbKUDeX5MATIb+CmASawGra2Hc7zNStP
-----END ENCRYPTED PRIVATE KEY-----', '1234');

        openssl_sign($data, $signature, $pkey, 'SHA256');
        return $data . '.' . base64_encode($signature);
    }
}