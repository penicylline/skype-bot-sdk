<?php

namespace SkypeBot\Entity\Card;

class ReceiptCard extends Base
{

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

    function setTap(CardAction $tap)
    {
        return $this->set('tap', $tap);
    }

    function getTap()
    {
        return $this->get('tap', CardAction::class);
    }

    function setTax($tax)
    {
        return $this->set('tax', $tax);
    }

    function getTax()
    {
        return $this->get('tax');
    }

    function setTitle($title)
    {
        return $this->set('title', $title);
    }

    function getTitle()
    {
        return $this->get('title');
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