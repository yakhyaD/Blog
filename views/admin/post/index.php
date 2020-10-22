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


<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Title</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">New Article</a>
        </th>
    </thead>
    <tbody>
    <?php foreach ($posts as $post): ?>
        <tr>
            <td>#<?= $post->getID() ?></td>
            <td><?= $post->getName() ?></td>
            <td>
                <a href="<?= $router->url('admin_post_edit', ['id' => $post->getID()]) ?>" class="btn btn-primary">Edit</a>
                <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>" method="POST" style="display: inline;"
                    onsubmit="return confirm('Confirm this suppression')">
                    <button class="btn btn-danger">Delete</button>
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