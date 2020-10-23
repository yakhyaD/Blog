<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validator\PostValidator;
use App\Objet;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$categoryTable = new CategoryTable($pdo);
$allCategories = $categoryTable->allCategories();
$categoryTable->hydratePosts([$post]);


$errors = [];
$success = false;
if(!empty($_POST)){
    $table = new PostValidator($_POST, $postTable, $post->getID(), $allCategories);
    Objet::hydrate($post, $_POST, ['name', 'content', 'slug', 'created']);
    if($table->validate()){
        $postTable->updatePost($post, $_POST['categories_ids']);
        $categoryTable->hydratePosts([$post]);
        $success = true;
    }
    else{
        $errors= $table->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if($success === true): ?>
    <div class="alert alert-success">
        Record edited !!
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Editing Failed. Verify your inputs !!
    </div>
<?php endif; ?>


<h1 class="mb-4">Edit the article: <?= $post->getName() ?></h1>
<?php require '_form.php' ?>