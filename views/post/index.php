<?php
use App\Model\Post;
use App\Helpers\Text;
use App\Router;
use App\Connection;
use App\Model\Category;
use App\PaginatedQuery;
use App\Table\PostTable;
use App\URL;

$pdo = Connection::getPDO();

// Pagination
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

$link = $router->url('home');
$title = "Mon blog"
?>

<h1>Mon blog</h1>
<div class="row">
    <?php foreach ($posts as $post): ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>


<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>    
</div>
