<?php

namespace SkypeBot\Interfaces;

use SkypeBot\Entity\Result;

interface ApiResultProcessor
{
    public function processResult(Result $result);
}