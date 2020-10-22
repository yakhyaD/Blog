<?php
namespace App;


class Objet {

    public static function hydrate( $table, $data, $fields)
    {
        if(!is_array($fields)){
            $set = 'set' . ucfirst($fields);
            $table->$set($data[$fields]);
        }
        foreach($fields as $field){
            $set = 'set' . ucfirst($field);
            $table->$set($data[$field]);
        }
    }
}
