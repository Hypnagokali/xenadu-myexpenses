<?php

namespace Model;

class Type implements ModelInterface
{
    private $name;
    private $descripton;
    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->descripton;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescription($description)
    {
        $this->descripton = $description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
