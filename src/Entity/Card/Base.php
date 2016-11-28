<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\HasText;
use SkypeBot\Entity\Card\Traits\HasTitle;
use SkypeBot\Entity\Entity;

abstract class Base extends Entity
{
    use HasText;
    use HasTitle;

    public function __construct()
    {
        $this->rawObj = new \stdClass();
    }

    function addButton(CardAction $button)
    {
        return $this->add('buttons', $button);
    }

    function getButtons()
    {
        return $this->get('buttons');
    }

    public abstract function getContentType();
}