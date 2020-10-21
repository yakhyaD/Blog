<?php
namespace App\Validator;

use App\Validator;

abstract class TableValidator{

    protected $validator;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
        $v = new Validator($_POST);
        $this->validator = $v;
    }

    public function validate(): bool
    {
        return $this->validator->validate();;
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }
}