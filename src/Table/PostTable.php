<?php
namespace App\Table;
use \PDO;
use App\PaginatedQuery;
use App\Model\Post;
use App\Model\Category;

class PostTable extends Table{
    
    protected $table = 'posts';
    protected $class = Post::class;

    public function delete(int $id)
    {
        $query = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE id = ?' );
        $result = $query->execute([$id]);
        if($result === false){
            throw new \Exception('This record from ' . $this->table . ' with id: ' . $id . 'table cannot be deleted ');
        }
    }
    public function update(Post $post)
    {
        $query = $this->pdo->prepare('UPDATE' . $this->table . 'SET name= :name, content= :content' . ' WHERE id = :id' );
        $result = $query->execute([
            'name' => $post->getName(),
            'content' => $post->getContent(),
            'id' => $post->getID()
        ]);
        if($result === false){
            throw new \Exception('This record from ' . $this->table . ' with id: ' .  $post->getID() . 'table cannot be edited ');
        }
    }
    

    public function findPaginated(): array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM posts ORDER BY created_at DESC ",
            "SELECT COUNT(id) FROM posts ",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID): array
    {

        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
            FROM posts p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id=  {$categoryID}
            ORDER BY created_at DESC",
            'SELECT COUNT(id) FROM category WHERE category.id=' . $categoryID
        );
        $posts = $paginatedQuery->getItems(Post::class);

        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }
}