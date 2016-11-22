<?php
namespace SkypeBot\Entity;


class JwkPayload extends Entity
{
    public function getExpired() {
        return $this->get('exp');
    }

    public function getNotBefore() {
        return $this->get('nbf');
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array('iss', 'aud', 'exp', 'nbf');
    }
}