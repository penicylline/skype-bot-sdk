<?php
namespace SkypeBot\Entity;

use SkypeBot\Exception\PayloadException;

abstract class Entity
{
    protected $rawObj;

    public function __construct($obj = null) {
        if ($obj === null) {
            $obj = new \stdClass();
        }
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

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws PayloadException
     */
    public function set($key, $value)
    {
        $this->validateInput($key, $value);
        if ($value instanceof Entity) {
            $this->rawObj->{$key} = $value->getRaw();
        } else {
            $this->rawObj->{$key} = $value;
        }
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws PayloadException
     */
    public function add($key, $value)
    {
        $this->validateInput($key, $value);
        if (!property_exists($this->rawObj, $key)) {
            $this->rawObj->{$key} = [];
        }
        $this->rawObj->{$key}[] = $value->getRaw();
        return $this;
    }

    /**
     * @param $obj
     * @throws PayloadException
     */
    protected function validateObject($obj) {
        $fields = $this->getRequiredFields();
        foreach ($fields as &$field) {
            if (!property_exists($obj, $field)) {
                throw new PayloadException('Missing field "' . $field . '" in ' . json_encode($obj));
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     * @throws PayloadException
     */
    protected function validateInput($key, $value)
    {
        if (!is_string($key)) {
            throw new PayloadException('Key should be string');
        }

        if (!(is_scalar($value) || is_array($value) || $value instanceof \stdClass || $value instanceof Entity)) {
            throw new PayloadException('Object should be scalar value or instance of stdClass or an Entity');
        }
        return true;
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return [];
    }
}