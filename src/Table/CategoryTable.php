<?php
namespace App\Table;

use App\Model\Category;
use \PDO;

class CategoryTable extends Table {

    protected $table = 'category';
    protected $class = Category::class;
    /**
     * @App\Model\Post[]
     */
    public function hydratePosts(array $posts): void
    {
        $PostByID = [];
        foreach($posts as $post){
            $PostByID[$post->getID()] = $post;
        }
        $categories = $this->pdo->query(
            'SELECT c.*, pc.post_id
            FROM post_category pc
            JOIN category c ON c.id = pc.category_id
            WHERE pc.post_id IN  (' . implode(',', array_keys($PostByID)) . ')'
            )->fetchAll(PDO::FETCH_CLASS, Category::class);
        foreach($categories as $category){
            $PostByID[$category->getPostID()]->addCategory($category);
        }
    }
}