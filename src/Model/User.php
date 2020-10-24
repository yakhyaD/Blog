<?php
namespace App\Model;

class User {

    /**
     * @var int
     */
     
    private $id;
    /**
     * @var string
     */
    private $username;


    /**
     * @var string
     */
    private $password;
    
    
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}