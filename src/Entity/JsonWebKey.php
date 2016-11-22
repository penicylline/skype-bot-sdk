<?php

namespace SkypeBot\Entity;

class JsonWebKey extends Entity
{

    const PUBLIC_KEY_SIGNATURE = 'sig';
    const PUBLIC_KEY_ENCRYPTION = 'enc';

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return [
            'kty',
            'use',
            'kid',
            'x5t',
            'n',
            'e',
            'x5c'
        ];
    }

    public function getKeyType()
    {
        return $this->get('kty');
    }

    public function getPublicKeyUse()
    {
        return $this->get('use');
    }

    public function getKeyId()
    {
        return $this->get('kid');
    }

    public function getModulus()
    {
        return $this->get('n');
    }

    public function getCertificateChain()
    {
        return $this->get('x5c');
    }
}