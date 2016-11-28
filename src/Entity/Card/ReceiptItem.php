<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\HasImage;
use SkypeBot\Entity\Card\Traits\HasSubtitle;
use SkypeBot\Entity\Card\Traits\HasText;
use SkypeBot\Entity\Card\Traits\HasTitle;
use SkypeBot\Entity\Card\Traits\Tapable;
use SkypeBot\Entity\Entity;

class ReceiptItem extends Entity
{
    use Tapable;
    use HasSubtitle;
    use HasImage;
    use HasText;
    use HasTitle;

    function setPrice($price)
    {
        return $this->set('price', $price);
    }

    function getPrice()
    {
        return $this->get('price');
    }

    function setQuantity($quantity)
    {
        return $this->set('quantity', $quantity);
    }

    function getQuantity()
    {
        return $this->get('quantity');
    }
}