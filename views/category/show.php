<?php 
use App\Model\Category;
use App\Connection;
use App\Model\Post;
use App\PaginatedQuery;
use App\Router;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\URL;

$perPage = 12;

$slug = $params['slug'];
$id = (int)$params['id'];

$pdo = Connection::getPDO();
$category = (new CategoryTable($pdo))->find($id);

if($category->getSlug() !== $slug){
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('location: ' . $url);
    exit();
}

$title = 'Category ' . $category->getName();


// Listing des articles
[$posts, $paginatedQuery] = (new PostTable($pdo))->findPaginatedForCategory($id);

$link =  $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()])
?>

<h1><?= htmlentities($title) ?></h1>

<div class="row mb-3">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__) .  '/post/card.php' ?>
        </div>
    <?php endforeach ?>
</div>


<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link) ?>
    <?= $paginatedQuery->nextLink($link) ?>
</div>