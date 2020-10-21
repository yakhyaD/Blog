<?php
namespace App;

use App\Model\Post;

class Objet {

    public static function hydrate(Post $post, $data, $fields)
    {
        if(!is_array($fields)){
            $set = 'set' . ucfirst($fields);
            $post->$set($data[$fields]);
        }
        foreach($fields as $field){
            $set = 'set' . ucfirst($field);
            
            $post->$set($data[$field]);
        }
    }
}
