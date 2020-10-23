<?php
namespace App;


class Objet {

    public static function hydrate( $object, array $data, array $fields): void
    {   
        foreach($fields as $field){
        $method = 'set' . str_replace(' ', '', ucfirst(str_replace('_', ' ', $field)));
        $object->$method($data[$field]);
        }
    }
}
