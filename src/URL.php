<?php
namespace App;

class URL {
    public static function getInt(string $name, int $default = null): ?int
    {
        if(!isset($_GET[$name])) return $default = 1;
    
        if(!filter_var($_GET[$name], FILTER_VALIDATE_INT)){
            throw new \Exception('Page Number must be an integer');
        };
        return (int)$_GET[$name];
    }
    
    public static function getPositiveInt(string $name, int $default = null): ?int
    {
        $param = self::getInt($name, $default);
        if($param !== null && $param <= 0){
            throw new \Exception('Number page can\'t be negative');
        }
        return $param;
    }
}