<?php

use App\Auth;
use App\Connection;
use App\HTML\Form;
use App\Model\Category;
use App\Validator;
use App\Objet;
use App\Table\CategoryTable;
use App\Validator\CategoryValidator;

Auth::check();

$errors = [];
$success = false;
$item = new Category();

if(!empty($_POST)){    
    $pdo = Connection::getPDO();
    $categoryTable = new CategoryTable($pdo);

    $table = new CategoryValidator($_POST, $categoryTable, $item->getID());
    Objet::hydrate($item, $_POST, ['name', 'slug']);
    if($table->validate()){
        $categoryTable->insertCategory($item);
        header('location:' . $router->url('admin_categories',['id' => $item->getID()]) . '?success=1');
        exit();
    }
    else{
        $errors= $table->errors();
    }
}

$form = new Form($item, $errors);
?>

<?php if(isset($_POST['success'])): ?>
    <div class="alert alert-success">
        Category Created !!
    </div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        Editing Failed. Fill all the fields correctly !!
    </div>
<?php endif; ?>


<h1 class="mb-4">New Category</h1>
<?php require '_form.php' ?>
