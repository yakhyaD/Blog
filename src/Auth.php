<?php
namespace App;

use Exception;

class Auth {

    public static function check()
    {
        if(!isset($params['admin'])){
            return new \Exception('Access Denied !!');
        }
    }
}