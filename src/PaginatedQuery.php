<?php
namespace App;
use PDO;

class PaginatedQuery {

    private $query;
    private $queryCount;
    private $perPage;
    private $offset;
    private $pdo;
    private $îtems;
    private $pages;
    private $CurrentPage;

    public function __construct(
        string $query,
        string $queryCount, 
        ?PDO $pdo = null, 
        int $perPage = 12
        )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping):array
    {
        $currentPage = $this->getCurrentPage() ;
        $this->pages = $this->getPages();
        $offset = (int)(($currentPage - 1)* $this->perPage);
        return $this->pdo->query(
                        $this->query .
                        " LIMIT {$this->perPage} OFFSET $offset")
                    ->fetchAll(PDO::FETCH_CLASS, $classMapping);
    }
    private function getCurrentPage(): ?int
    {
        if($this->CurrentPage === null){
            $this->CurrentPage = URL::getPositiveInt('page', 1);
        }
        return $this->CurrentPage;
    }
    private function getPages(): ?int
    {
        if($this->pages === null){
            $this->count = (int)$this->pdo->query($this->queryCount)
                            ->fetch(PDO::FETCH_NUM)[0];
            $this->pages = ceil($this->count / $this->perPage);
        }
        return $this->pages;
    }
    public function nextLink(string $link) 
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage < $this->getPages()){
            $link .= '?page=' . ($currentPage +1);
            return <<<HTML
            <a href='$link' class="btn btn-primary"> Next Page &laquo;</a>
HTML;
        } 
    }
    public function previousLink(string $link)
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage > 1) {
            if($currentPage > 2){
                $link .= '?page=' . ($currentPage -1);
            }
        return <<<HTML
        <a href='$link' class="btn btn-primary">&laquo; Previous Page</a>
HTML;
        }
    }
}