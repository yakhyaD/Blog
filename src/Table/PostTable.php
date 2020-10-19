<?php
namespace App\Table;
use \PDO;
use App\PaginatedQuery;
use App\Model\Post;
use App\Model\Category;

class PostTable extends Table{
    
    protected $table = 'posts';
    protected $class = Post::class;

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