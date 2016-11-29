<?php

namespace SkypeBot\Entity;

class Result extends Entity
{
    /**
     * @return null|Error
     */
    public function getError()
    {
        return $this->get('error', Error::class);
    }

    public function getId()
    {
        return $this->get('id');
    }
}