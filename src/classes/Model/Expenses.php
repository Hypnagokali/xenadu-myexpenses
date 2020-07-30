<?php

namespace Model;

use Model\Type;

class Expenses implements ModelInterface
{
    private $id;
    private $user_id;
    private $type;
    private $sum;
    private $location;
    private $occured_at;

    public function __construct()
    {
        $this->id = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getOccurredAt()
    {
        return $this->occured_at;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($uid)
    {
        $this->user_id = $uid;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setOccurredAt($occured_at)
    {
        $this->occured_at = $occured_at;
    }
}
