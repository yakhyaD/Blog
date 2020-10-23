<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Table\PostTable;
use App\Validator;
use App\Validator\PostValidator;
use App\Objet;
use App\Model\Post;
use App\Table\CategoryTable;


Auth::check();

$errors = [];
$success = false;
$post = new Post();
$pdo = Connection::getPDO();
$allCategories = (new CategoryTable($pdo))->allCategories();

if(!empty($_POST)){    
    $pdo = Connection::getPDO();
    $postTable = new PostTable($pdo);

    $table = new PostValidator($_POST, $postTable, $post->getID());
    Objet::hydrate($post, $_POST, ['name', 'content', 'slug', 'created']);
    if($table->validate()){
        $postTable->insertPost($post);
        header('location:' . $router->url('admin_posts',['id' => $post->getID()]) . '?success=1');
        exit();
    }
    else{
        $errors= $table->errors();
    }
}

$form = new Form($post, $errors);
?>

<?php if(isset($_POST['succes'])): ?>
    <div class="alert alert-success">
        Record Created !!
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Editing Failed. Fill all the fields correctly !!
    </div>
<?php endif; ?>


<h1 class="mb-4">New Article</h1>
<?php require '_form.php' ?>
