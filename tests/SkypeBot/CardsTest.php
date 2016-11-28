<?php

use PHPUnit_Framework_TestCase as TestCase;

class CardsTest extends TestCase
{

    function testSignInCard()
    {
        $card = new \SkypeBot\Entity\Card\SignInCard();
        $card->setTitle('a');
        $this->assertEquals($card->getTitle(), 'a');
        $card->setText('b');
        $this->assertEquals($card->getText(), 'b');
        $button = new \SkypeBot\Entity\Card\CardAction();
        $button->setTitle('t');
        $card->addButton($button);
        $this->assertEquals($card->getButtons()[0]->title, 't');
    }

    function testSubElements()
    {
        $button = new \SkypeBot\Entity\Card\CardAction();
        $button->setImage('i');
        $this->assertEquals($button->getImage(), 'i');
        $button->setType('t');
        $this->assertEquals($button->getType(), 't');
        $button->setValue('v');
        $this->assertEquals($button->getValue(), 'v');

        $image = new \SkypeBot\Entity\Card\CardImage();
        $image->setAlt('a');
        $this->assertEquals($image->getAlt(), 'a');
        $image->setUrl('u');
        $this->assertEquals($image->getUrl(), 'u');

        $fact = new \SkypeBot\Entity\Card\Fact();
        $fact->setKey('k');
        $this->assertEquals($fact->getKey(), 'k');
        $fact->setValue('v');
        $this->assertEquals($fact->getValue(), 'v');

        $media = new \SkypeBot\Entity\Card\MediaUrl();
        $media->setUrl('u');
        $this->assertEquals($media->getUrl(), 'u');
        $media->setProfile('p');
        $this->assertEquals($media->getProfile(), 'p');

        $item = new \SkypeBot\Entity\Card\ReceiptItem();
        $item->setImage($image);
        $this->assertEquals($item->getImage()->getAlt(), 'a');
        $item->setPrice('p');
        $this->assertEquals($item->getPrice(), 'p');
        $item->setQuantity(5);
        $this->assertEquals($item->getQuantity(), 5);
    }

    function testAudioCard()
    {
        $image = new \SkypeBot\Entity\Card\CardImage();
        $image->setAlt('a');
        $media = new \SkypeBot\Entity\Card\MediaUrl();
        $media->setUrl('u');
        $card = new \SkypeBot\Entity\Card\AudioCard();
        $card->setImage($image);
        $this->assertEquals($card->getImage()->getAlt(), 'a');
        $card->addMedia($media);
        $this->assertEquals($card->getMedia()[0]->url, 'u');
        $card->setAutoloop(true);
        $this->assertTrue($card->getAutoloop());
        $card->setAutostart(true);
        $this->assertTrue($card->getAutostart());
        $card->setShareable(true);
        $this->assertTrue($card->getShareable());
        $card->setAspect('a');
        $this->assertEquals($card->getAspect(), 'a');
        $card->setSubtitle('s');
        $this->assertEquals($card->getSubtitle(), 's');
    }

    function testHeroCard()
    {
        $card = new \SkypeBot\Entity\Card\HeroCard();
        $button = new \SkypeBot\Entity\Card\CardAction();
        $button->setValue('v');
        $card->addButton($button);
        $this->assertEquals($card->getButtons()[0]->value, 'v');
        $image = new \SkypeBot\Entity\Card\CardImage();
        $image->setUrl('u');
        $card->addImage($image);
        $this->assertEquals($card->getImages()[0]->url, 'u');
    }
}