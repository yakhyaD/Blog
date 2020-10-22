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

    public function all(): array
    {
        $sql = 'SELECT * FROM ' . $this->table;
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    public function delete(int $id)
    {
        $query = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE id = ?' );
        $result = $query->execute([$id]);
        if($result === false){
            throw new \Exception('This record from ' . $this->table . ' with id: ' . $id . 'table cannot be deleted ');
        }
    }

    public function insert(array $data): int
    {
        $sqlFields = [];
        foreach($data as $key => $value)
        {
            $sqlFields[] = "$key= :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO  {$this->table} SET " . implode(', ',$sqlFields));
        $result = $query->execute($data);
        if($result === false){
            throw new \Exception('Impossible to create new record in table' . $this->table  );
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data, int $id)
    {
        $sqlFields = [];
        foreach($data as $key => $value)
        {
            $sqlFields[] = "$key= :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ',$sqlFields) . " WHERE id= :id");
        $result = $query->execute(array_merge($data, ['id' => $id]));
        if($result === false){
            throw new \Exception('Impossible to create new record in table' . $this->table  );
        }
    }

    public function QueryandFetchAll(string $sql):array
    {
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

}