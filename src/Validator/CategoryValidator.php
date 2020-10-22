<?php
namespace App\Validator;

use App\Table\CategoryTable;
use App\Table\PostTable;
use App\Table\Table;
use App\Validator;

class CategoryValidator extends TableValidator{


    public function __construct($data, CategoryTable $table, ?int $id = null)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 5, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function($field, $value) use ($table, $id){
            return !$table->exist($field, $value, $id) ;
        }, ['name','slug'], 'This value is already used');
    }
}