<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\Tapable;

class ReceiptCard extends Base
{
    use Tapable;

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.receipt';
    }

    function addFact(Fact $fact)
    {
        return $this->add('facts', $fact);
    }

    function getFacts()
    {
        return $this->get('facts');
    }

    function addItem(ReceiptItem $item)
    {
        return $this->add('items', $item);
    }

    function getItems()
    {
        return $this->get('items');
    }

    function setTax($tax)
    {
        return $this->set('tax', $tax);
    }

    function getTax()
    {
        return $this->get('tax');
    }

    function setTotal($total)
    {
        return $this->set('total', $total);
    }

    function getTotal()
    {
        return $this->get('total');
    }

    function setVat($vat)
    {
        return $this->set('vat', $vat);
    }

    function getVat()
    {
        return $this->get('vat');
    }

}