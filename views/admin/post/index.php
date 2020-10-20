<?php
use App\Connection;
use App\Table\PostTable;

$title = 'Administatration';
$pdo = Connection::getPDO();

// Pagination
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();
$link = $router->url('admin_posts');
?>
<?php if(isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        Record deleted successfully
    </div>
<?php endif; ?>


<table class="table">
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Action</th>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td>#<?= $post->getID() ?></td>
            <td><?= $post->getName() ?></td>
            <td>
                <a href="<?= $router->url('admin_post_edit', ['id' => $post->getID()]) ?>" class="btn btn-primary">Edit</a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" method="POST" style="display: inline;">
                    <button class="btn btn-danger" submit="return confirm('Confirm this suppression')">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>    
</div>