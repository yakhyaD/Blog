<?php
namespace App\Table;
use \PDO;
use App\PaginatedQuery;
use App\Model\Post;

class PostTable extends Table{
    
    protected $table = 'posts';
    protected $class = Post::class;

    public function updatePost(Post $post, array $categoriesIds)
    {
        $this->pdo->beginTransaction();
        $this->update([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreated()->format('Y-m-d H:m:s'),
        ], $post->getID());
       
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0 ");
        $this->pdo->exec('DELETE FROM post_category WHERE post_id=' . $post->getID());
        $query = $this->pdo->prepare("INSERT INTO post_category SET post_id= ?, category_id = ?");
        foreach($categoriesIds as $categoryID){
            $query->execute([$post->getID(), $categoryID]);
        }
        $this->pdo->commit();
    }

    public function insertPost(Post $post): void
    {
        $id = $this->insert([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreated()->format('Y-m-d H:i:s')
        ]);
        $post->setID($id);
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