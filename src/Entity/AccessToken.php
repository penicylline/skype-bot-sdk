<?php
namespace SkypeBot\Entity;


class AccessToken extends Entity
{
    public function __construct($obj)
    {
        $obj->expried_time = time() + $obj->expires_in;
        parent::__construct($obj);
    }

    public function getToken() {
        return $this->get('access_token');
    }

    public function getExpiredTime() {
        return $this->get('expried_time');
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array('access_token', 'expires_in');
    }
}