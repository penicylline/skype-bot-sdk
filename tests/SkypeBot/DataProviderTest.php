<?php

use PHPUnit_Framework_TestCase as TestCase;

class DataProviderTest extends TestCase
{
    /**
     * @var \SkypeBot\SkypeBot
     */
    private $bot;

    function setUp()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $storage = new \SkypeBot\Storage\MemoryStorage();
        $this->bot = SkypeBot\SkypeBot::init($config, $storage);
    }

    function testProviders()
    {
        $now = time();
        $this->bot->set('http_client', $this->createHttpClientMock());

        //
        $token = $this->bot->getTokenProvider()->getAccessToken();
        $this->assertGreaterThan($now, $token->getExpiredTime());
        $this->assertEquals($token->getToken(), 1);
        $this->assertEquals($this->bot->getTokenProvider()->getAccessToken()->getToken(), 1);
        $this->bot->getTokenProvider()->clearToken();
        $this->assertNull($this->bot->getDataStorage()->get(\SkypeBot\DataProvider\TokenProvider::KEY_STORAGE));

        //
        $config = $this->bot->getOpenIdConfigProvider()->getConfig();
        $this->assertEquals($config->getIssuer(), 1);
        $this->assertEquals($config->getJwksUri(), 2);
        $this->assertEquals($config->getSigningAlg(), 4);

        //
        $keys = $this->bot->getOpenIdKeysProvider()->getKeys();
        $this->assertEquals(count($keys), 1);
        $key = array_shift($keys);
        $this->assertEquals($key->getKeyType(), 1);
        $this->assertEquals($key->getPublicKeyUse(), 2);
        $this->assertEquals($key->getKeyId(), 3);
        $this->assertEquals($key->getModulus(), 5);
        $this->assertEquals($key->getCertificateChain(), 7);
    }

    protected function createHttpClientMock()
    {
        $httpClient = $this->getMockBuilder('\\SkypeBot\\Api\\HttpClient')
            ->disableOriginalConstructor()
            ->setMethods(['post', 'get'])
            ->getMock();

        $tokenObj = new stdClass();
        $tokenObj->access_token = 1;
        $tokenObj->expires_in = 2;
        $httpClient->expects($this->any())
            ->method('post')
            ->will($this->returnValue(json_encode($tokenObj)));

        $configObj = new stdClass();
        $configObj->issuer = 1;
        $configObj->jwks_uri = 2;
        $configObj->authorization_endpoint = 3;
        $configObj->id_token_signing_alg_values_supported = 4;
        $configObj->token_endpoint_auth_methods_supported = 5;
        $httpClient->expects($this->at(1))
            ->method('get')
            ->will($this->returnValue(json_encode($configObj)));


        $jwk = new stdClass();
        $jwk->kty = 1;
        $jwk->use = 2;
        $jwk->kid = 3;
        $jwk->x5t = 4;
        $jwk->n = 5;
        $jwk->e = 6;
        $jwk->x5c = 7;
        $httpClient->expects($this->at(2))
            ->method('get')
            ->will($this->returnValue(json_encode(['keys' => [$jwk]])));

        return $httpClient;
    }
}