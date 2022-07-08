<?php

namespace App\Entity;

class FriendsSearch {

    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return FriendsSearch
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}