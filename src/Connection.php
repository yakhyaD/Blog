<?php 
namespace App;
use PDO;
class Connection {

    public static function getPDO(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=blogphp','root', 'Yakhya123', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}