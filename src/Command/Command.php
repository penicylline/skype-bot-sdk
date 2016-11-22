<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;

abstract class Command {
    /**
     * @return Api
     */
    public abstract function getApi();
    public abstract function processResult($result);
}
