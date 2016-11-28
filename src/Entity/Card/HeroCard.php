<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\HasSubtitle;
use SkypeBot\Entity\Card\Traits\ImageList;
use SkypeBot\Entity\Card\Traits\Tapable;

class HeroCard extends Base
{
    use Tapable;
    use ImageList;
    use HasSubtitle;

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.hero';
    }
}