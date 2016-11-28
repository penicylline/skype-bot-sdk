<?php
/**
 * Created by PhpStorm.
 * User: hoaibui
 * Date: 11/25/16
 * Time: 3:15 PM
 */

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\Tapable;
use SkypeBot\Entity\Entity;

class CardImage extends Entity
{
    use Tapable;

    function setAlt($alt)
    {
        return $this->set('alt', $alt);
    }

    function getAlt()
    {
        return $this->get('alt');
    }

    function setUrl($url)
    {
        return $this->set('url', $url);
    }

    function getUrl()
    {
        return $this->get('url');
    }
}