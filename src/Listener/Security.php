<?php

namespace SkypeBot\Listener;

use SkypeBot\DataProvider\OpenIdKeysProvider;
use SkypeBot\Entity\Jwk\JsonWebKey;
use SkypeBot\Entity\Jwk\JwkInfo;
use SkypeBot\Entity\Jwk\JwkPayload;
use SkypeBot\Exception\SecurityException;
use SkypeBot\SkypeBot;

class Security
{
    const SUPPORTED_ALGORITHM = 'RS256';

    const TIME_MARGIN = 120; //margin 2 minutes

    private $keyProvider;

    /**
     * @return OpenIdKeysProvider
     */
    private function getKeyProvider()
    {
        if ($this->keyProvider === null) {
            $this->keyProvider = SkypeBot::getInstance()->getOpenIdKeysProvider();
        }
        return $this->keyProvider;
    }

    public function validateBearerHeader($header)
    {
        $bearerData = $this->extractBearerData($header);
        $tokenParts = explode('.', $bearerData);
        if (count($tokenParts) !== 3) {
            throw new SecurityException('Authenticate header is not valid format');
        }
        list($keyInfo, $payload, $signature) = $tokenParts;
        $keyInfoObj = json_decode(base64_decode($keyInfo));
        $payloadObj = json_decode(base64_decode($payload));

        if (!isset($keyInfoObj, $payloadObj)) {
            throw new SecurityException('Authenticate header key info part is not valid format');
        }
        $jwkInfo = new JwkInfo($keyInfoObj);
        $jwkPayload = new JwkPayload($payloadObj);

        //checking key valid time
        $now = time();
        if ($jwkPayload->getExpired() < $now - static::TIME_MARGIN) {
            throw new SecurityException('Token expired at: ' . date('Y-m-d H:i:s', $jwkPayload->getExpired()));
        }
        if ($jwkPayload->getNotBefore() > $now + static::TIME_MARGIN) {
            throw new SecurityException('Token cannot use before: ' . date('Y-m-d H:i:s', $jwkPayload->getNotBefore()));
        }

        //checking supported encrypt algorithm
        if ($jwkInfo->getAlgorithm() != static::SUPPORTED_ALGORITHM) {
            throw new SecurityException('Unsupported key type: ' . $jwkInfo->getAlgorithm());
        }

        //get correct public key from the list
        $signingKey = $this->getKeyProvider()->getKeyById($jwkInfo->getKeyId());
        if ($signingKey === null) {
            $this->getKeyProvider()->resyncKeys();
            $signingKey = $this->getKeyProvider()->getKeyById($jwkInfo->getKeyId());
            if ($signingKey === null) {
                throw new SecurityException('Cannot find signing key of the header');
            }
        }

        // checking public key usage - only support signature
        if ($signingKey->getPublicKeyUse() != JsonWebKey::PUBLIC_KEY_SIGNATURE) {
            throw new SecurityException('Unsupported public key usage: ' . $signingKey->getPublicKeyUse());
        }
        $pKey = $this->getPublicKey($signingKey->getCertificateChain()[0]);
        return $this->verify(
            $keyInfo,
            $payload,
            $signature,
            $pKey,
            'SHA256'
        );
    }

    private function extractBearerData($header)
    {
        if (substr($header, 0, 7) != 'Bearer ') {
            throw new SecurityException('Authorization header should start with Bearer');
        }
        return substr($header, 7);
    }

    private function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    private function verify($keyInfo, $payload, $signature, $key, $algorithm)
    {
        $msg = $keyInfo . '.' . $payload;
        $signature = $this->base64UrlDecode($signature);
        return openssl_verify($msg, $signature, $key, $algorithm);
    }

    private function getPublicKey($cert)
    {
        $certObj = openssl_x509_read(
            sprintf(
                "-----BEGIN CERTIFICATE-----\n%s-----END CERTIFICATE-----\n",
                chunk_split($cert, 64)
            )
        );
        $pkeyObj = openssl_pkey_get_public($certObj);
        $pkeyArr = openssl_pkey_get_details($pkeyObj);
        return $pkeyArr['key'];
    }

}