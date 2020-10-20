<?php
namespace App;

use Exception;

class Auth {

    public static function check()
    {
        if(!isset($params['admin'])){
            return new \Exception('You must be registered as an admin');
        }
    }
}