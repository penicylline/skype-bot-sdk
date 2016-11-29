<?php

namespace SkypeBot\Entity;

class Error extends Entity
{
    public function getMessage()
    {
        return $this->get('message');
    }
}