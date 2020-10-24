<?php
namespace App\security;

use Exception;

class ForbiddenException extends Exception {

    public function __construct()
    {
        $this->message = 'Access Denied ';
    }
}