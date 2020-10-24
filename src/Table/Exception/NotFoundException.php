<?php
namespace App\Table\Exception;

use Exception;

class NotFoundException extends Exception {

    public function __construct(string $table, $id)
    {
        $this->message = 'there is no records with id:' . $id . 'in ' . $table . 'table';
    }
} 