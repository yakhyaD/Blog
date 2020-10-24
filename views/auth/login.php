<?php

use App\Connection;
use App\HTML\Form;
use App\Model\User;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User;

$errors = [];
if(!empty($_POST)){
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Username or Password incorrect';

    if(!empty($_POST['username']) && !empty($_POST['password'])){

        $table = new UserTable(Connection::getPDO());
        try {
            $userInf = $table->findByUsername($_POST['username']);
            
            if(password_verify($_POST['password'], $userInf->getPassword()) === true){
                session_start();
                $_SESSION['auth'] = $userInf->getId();
                header('location: ' . $router->url('admin_posts'));
                exit();
            }
        } catch (NotFoundException $e){
        }
   }
}
$form = new Form($user, $errors);
?>
<?php if(isset($_GET['forbidden'])): ?>
    <div class="alert alert-danger">
        Access Denied !!!
    </div>
<?php endif; ?>

<?php if(isset($_GET['deconnected'])): ?>
    <div class="alert alert-success">
        You are logged out !!!
    </div>
<?php endif; ?>

<h1>Login</h1>
<form action="<?= $router->url('login') ?>" method="POST">
    <?= $form->input('username', 'Username') ?>
    <?= $form->input('password', 'Password') ?>
    <button type="submit" class="btn btn-primary btn-block" >login</button>
</form>