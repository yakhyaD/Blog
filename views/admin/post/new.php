<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validator\PostValidator;
use App\Objet;
use App\Model\Post;


Auth::check();

$errors = [];
$success = false;
$post = new Post();


if(!empty($_POST)){
    
    $pdo = Connection::getPDO();
    // $postTable = new PostTable($pdo);

    // $table = new PostValidator($_POST, $postTable, $post->getID());
    // dd($table);
    // Objet::hydrate($post, $_POST, ['name', 'content', 'slug', 'createdAt']);
    // if($table->validate()){
    //     $postTable->insert($post);
    //     header('location:' . $router->url('admin_post_edit'), ['id' => $post->getID()] . '?created=1');
    // }
    // else{
    //     $errors= $table->errors();
    // }
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
        Editing Failed. Fill all the fields correctly !!
    </div>
<?php endif; ?>


<h1 class="mb-4">New Article</h1>
<form action="" method="POST">
    <?= $form->input('name', 'Name') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->input('createdAt', 'Created At') ?>
    <?= $form->textarea('content', 'Content') ?>
    <button class="btn btn-primary">Create</button>
</form>