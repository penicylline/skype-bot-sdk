<?php
namespace SkypeBot\Exception;

class CurlException extends  \Exception
{
    protected $curlInfo;

    public function setInfo($info) {
        $this->curlInfo = $info;
        return $this;
    }

    public function getInfo() {
        return $this->curlInfo;
    }
}