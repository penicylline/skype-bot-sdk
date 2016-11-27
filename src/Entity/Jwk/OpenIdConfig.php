<?php

namespace SkypeBot\Entity\Jwk;

use SkypeBot\Entity\Entity;

class OpenIdConfig extends Entity
{

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return [
            'issuer',
            'authorization_endpoint',
            'jwks_uri',
            'id_token_signing_alg_values_supported',
            'token_endpoint_auth_methods_supported'
        ];
    }

    public function getIssuer()
    {
        return $this->get('issuer');
    }

    public function getJwksUri()
    {
        return $this->get('jwks_uri');
    }

    public function getSigningAlg() {
        return $this->get('id_token_signing_alg_values_supported');
    }
}