<?php
namespace SkypeBot\Entity;


class JwkInfo extends Entity
{
    public function getKeyId() {
        return $this->get('kid');
    }

    public function getAlgorithm() {
        return $this->get('alg');
    }

    public function getType() {
        return $this->get('typ');
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array('typ', 'alg', 'kid', 'x5t');
    }
}