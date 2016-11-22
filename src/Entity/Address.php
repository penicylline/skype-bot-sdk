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

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array('id', 'name');
    }
}