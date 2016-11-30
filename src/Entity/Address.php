<?php
namespace SkypeBot\Entity;


class Address extends Entity
{
    public function getId() {
        return $this->get('id');
    }

    public function getName() {
        return $this->get('name');
    }

    public function setId($id) {
        return $this->set('id', $id);
    }

    public function setName($name) {
        return $this->set('name', $name);
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array('id');
    }
}