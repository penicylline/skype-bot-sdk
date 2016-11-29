<?php

namespace SkypeBot\Command;

use SkypeBot\Entity\Result;
use SkypeBot\Interfaces\ApiResultProcessor;

abstract class ApiCommand extends Command
{
    protected $resultProcessor;

    public function setResultProcessor($processor)
    {
        $this->resultProcessor = $processor;
    }

    /**
     * @param $result
     * @return Result
     */
    public function processResult($result)
    {
        $result = new Result($result);
        if ($this->resultProcessor instanceof ApiResultProcessor) {
            return $this->resultProcessor->processResult($result);
        }
        if (is_callable($this->resultProcessor)) {
            return call_user_func_array($this->resultProcessor, [$result]);
        }
        return $result;
    }
}