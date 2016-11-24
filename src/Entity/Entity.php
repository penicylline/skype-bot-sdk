<?php
namespace SkypeBot\Entity;

use SkypeBot\Exception\PayloadException;

abstract class Entity
{
    protected $rawObj;

    public function __construct($obj) {
        $this->validateObject($obj);
        $this->rawObj = $obj;
    }

    public function getRaw()
    {
        return $this->rawObj;
    }

    protected function get($property, $type = null) {
        if (property_exists($this->rawObj, $property)) {
            if ($type && !($this->rawObj->{$property} instanceof $type)) {
                $this->rawObj->{$property} = new $type($this->rawObj->{$property});
            }
            return $this->rawObj->{$property};
        }
        return null;
    }

    protected function validateObject($obj) {
        $fields = $this->getRequiredFields();
        foreach ($fields as &$field) {
            if (!property_exists($obj, $field)) {
                throw new PayloadException('Missing field "' . $field . '" in ' . json_encode($obj));
            }
        }
    }

    /**
     * @return array
     */
    abstract protected function getRequiredFields();
}