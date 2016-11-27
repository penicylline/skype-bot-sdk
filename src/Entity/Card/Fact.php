<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Entity;

class Fact extends Entity
{
    function setKey($key)
    {
        return $this->set('key', $key);
    }

    function getKey()
    {
        return $this->get('key');
    }

    function setValue($value)
    {
        return $this->set('value', $value);
    }

    function getValue()
    {
        return $this->get('value');
    }

}