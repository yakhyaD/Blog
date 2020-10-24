<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;
use App\Table\PostTable;

Auth::check();

$title = 'Administatration';
$pdo = Connection::getPDO();

// Pagination
$items = (new CategoryTable($pdo))->all();

?>
<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        Record deleted successfully
    </div>
<?php endif; ?>


<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>URL</th>
        <th>
            <a href="<?= $router->url('admin_category_new') ?>" class="btn btn-primary">New Category</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td>#<?= $item->getID() ?></td>
            <td><?= $item->getName() ?></td>
            <td>
                <a href="<?= $router->url('admin_category_edit', ['id' => $item->getID()]) ?>" class="btn btn-primary">Edit</a>
                <form action="<?= $router->url('admin_category_delete', ['id' => $item->getID()]) ?>" method="POST" style="display: inline;"
                onsubmit="return confirm('Confirm this suppression')">
                    <button class="btn btn-danger" >Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
