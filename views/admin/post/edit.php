<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validator\PostValidator;
use App\Objet;

$pdo = Connection::getPDO();
Auth::check();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);

$errors = [];
$success = false;

if(!empty($_POST)){
    $table = new PostValidator($_POST, $postTable, $post->getID());
    Objet::hydrate($post, $_POST, ['name', 'content', 'slug', 'created']);
    if($table->validate()){
        $postTable->updatePost($post);
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