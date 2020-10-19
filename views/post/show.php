<?php

use App\Model\Category;
use App\Connection;
use App\Model\Post;
use App\Router;
use App\Table\CategoryTable;
use App\Table\PostTable;

$slug = $params['slug'];
$id = (int)$params['id'];

$pdo = Connection::getPDO();
$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if($post->getSlug() !== $slug){
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location: ' . $url);
    exit();
}


?>

<h1><?= $post->getName() ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php  
    foreach($post->getCategories() as $k => $category):
        if($k > 0):
            echo ',';
        endif; 
?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= $category->getName() ?></a>    
<?php endforeach; ?>
<p><?= $post->getContent() ?></p>
