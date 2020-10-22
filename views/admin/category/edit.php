<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Validator;
use App\Validator\PostValidator;
use App\Objet;
use App\Table\CategoryTable;
use App\Validator\CategoryValidator;

$pdo = Connection::getPDO();
Auth::check();
$categoryTable = new CategoryTable($pdo);
$item = $categoryTable->find($params['id']);

$errors = [];
$success = false;

if(!empty($_POST)){
    $table = new CategoryValidator($_POST, $categoryTable, $item->getID());
    Objet::hydrate($item, $_POST, ['name','slug']);
    if($table->validate()){
        $categoryTable->updateCategory($item);
        $success = true;
    }
    else{
        $errors= $table->errors();
    }
}

$form = new Form($item, $errors);
?>

<?php if($success): ?>
    <div class="alert alert-success">
        Record edited !!
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Editing Failed. Verify your inputs !!
    </div>
<?php endif; ?>


<h1 class="mb-4">Edit the category: <?= $item->getName() ?></h1>
<?php require '_form.php' ?>