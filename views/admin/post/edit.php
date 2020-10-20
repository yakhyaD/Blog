<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

$pdo = Connection::getPDO();
Auth::check();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

if(!empty($_POST)){
    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content']);
    $postTable->update($post);
}
?>
<h1 class="mb-4">Edit the article: <?= $post->getName() ?></h1>
<form action="" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="<?= $post->getName() ?>"/>
    </div>
    <div class="form-group">
        <textarea name="content" type="text" class="form-control"><?= $post->getContent() ?></textarea>
    </div>
    <button class="btn btn-primary">Edit</button>
</form>