<?php

namespace SkypeBot\Entity\Card;

class SignInCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.signin';
    }

}