<?php
namespace App\Validator;

use App\Table\PostTable;
use App\Table\Table;
use App\Validator;

class PostValidator extends TableValidator{


    public function __construct($data, PostTable $table, ?int $postID = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 5, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function($field, $value) use ($table, $postID){
            return !$table->exist($field, $value, $postID) ;
        }, ['name','slug'], 'This value is already used');
    }
}