<?php

namespace SkypeBot\Listener;

use SkypeBot\Entity\ContactUpdatePayload;
use SkypeBot\Entity\ConversationUpdatePayload;
use SkypeBot\Entity\MessagePayload;
use SkypeBot\Exception\PayloadException;
use SkypeBot\Exception\SecurityException;
use SkypeBot\Interfaces\ApiLogger;
use SkypeBot\Interfaces\ContactUpdateHandler;
use SkypeBot\Interfaces\ConversationUpdateHandler;
use SkypeBot\Interfaces\MessageHandler;

class Dispatcher
{
    /**
     * @var Security
     */
    protected $security;

    /**
     * @var MessageHandler
     */
    protected $messageHandler;

    /**
     * @var ContactUpdateHandler
     */
    protected $contactUpdateHandler;

    /**
     * @var ConversationUpdateHandler
     */
    protected $conversationUpdateHandler;

    /**
     * @var ApiLogger
     */
    protected $apiLogger;

    /**
     * @var Payload
     */
    protected $payload;

    protected $headers;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function dispatch()
    {
        $this->fetchRequest();
        if ($this->payload instanceof MessagePayload) {
            $this->handleMessage();
        }
        if ($this->payload instanceof ConversationUpdatePayload) {
            $this->handleContactUpdate();
        }
        if ($this->payload instanceof ContactUpdatePayload) {
            $this->handleContactUpdate();
        }

        $this->sendResponse();
    }

    public function setContactHandler($handler)
    {
        $this->contactUpdateHandler = $handler;
        return $this;
    }

    public function setConversationHandler($handler)
    {
        $this->conversationUpdateHandler = $handler;
        return $this;
    }

    public function setMessageHandler($handler)
    {
        $this->messageHandler = $handler;
        return $this;
    }

    public function setApiLogger(ApiLogger $logger)
    {
        $this->apiLogger = $logger;
        return $this;
    }

    protected function fetchRequest()
    {
        $this->validateAuthenticateHeader();
        $requestBody = file_get_contents('php://input');
        $requestObj = json_decode($requestBody);
        if (empty($requestObj)) {
            throw new PayloadException('Empty or invalid json format: "' . $requestBody . '"');
        }
        $this->payload = PayloadFactory::createPayload($requestObj);
        $this->logRequest($requestBody);
    }

    protected function sendResponse()
    {
        http_response_code(201);
    }

    protected function handleMessage() {
        if ($this->messageHandler === null)
        {
            return;
        }
        if ($this->messageHandler instanceof MessageHandler) {
            return $this->messageHandler->handlerMessage($this->payload);
        }
        if (is_callable($this->messageHandler)){
            call_user_func_array($this->messageHandler, [$this->payload]);
        }
    }

    protected function handleContactUpdate() {
        if ($this->contactUpdateHandler === null)
        {
            return;
        }
        if ($this->contactUpdateHandler instanceof ContactUpdateHandler) {
            return $this->contactUpdateHandler->handlerPayload($this->payload);
        }
        if (is_callable($this->contactUpdateHandler)){
            call_user_func_array($this->contactUpdateHandler, [$this->payload]);
        }
    }

    protected function handleConversationUpdate()
    {
        if ($this->conversationUpdateHandler === null) {
            return;
        }
        if ($this->conversationUpdateHandler instanceof ConversationUpdateHandler) {
            return $this->conversationUpdateHandler->handlerPayload($this->payload);
        }
        if (is_callable($this->conversationUpdateHandler)){
            call_user_func_array($this->conversationUpdateHandler, [$this->payload]);
        }
    }

    protected function validateAuthenticateHeader()
    {
        $headers = $this->getAllHeaders();
        if (!isset($headers['Authorization'])) {
            throw new SecurityException('Request missing authorization header');
        }

        $result = $this->security->validateBearerHeader($headers['Authorization']);
        if ($result != 1) {
            throw new SecurityException('Invalid authenticate data');
        }
    }

    protected function logRequest($requestBody)
    {
        if ($this->apiLogger === null) {
            return;
        }
        $headers = $this->getAllHeaders();
        $message = print_r($headers, true) . PHP_EOL . $requestBody;
        $this->apiLogger->log($message);
    }

    private function getAllHeaders()
    {
        if ($this->headers ===  null) {
            if (function_exists('getallheaders')) {
                return getallheaders();
            }
            $this->headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $this->headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }
        return $this->headers;
    }
}