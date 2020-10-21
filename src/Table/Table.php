<?php
namespace App\Table;

use App\Table\Exception\NotFoundException;
use \PDO;

abstract class Table {

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(PDO $pdo)
    {
        if($this->table === null){
            throw new \Exception('The class' . get_class($this) . 'has no propiety' . $this->table);
        } 
        if($this->class === null){
            throw new \Exception('The class' . get_class($this) . 'has no propiety' . $this->class);
        }
        $this->pdo = $pdo;
    }
    public function find(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id'=> $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false){
            new NotFoundException($this->table, $id);
        }
        return $result;
    }

    public function exist (string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE {$field}= ?";
        $params = [$value];
        if($except !== null){
            $sql .= " AND id != ?"; 
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetch(PDO::FETCH_NUM)[0] > 0;
    }
}