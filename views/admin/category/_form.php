<form action="" method="POST">
    <?= $form->input('name', 'Name') ?>
    <?= $form->input('slug', 'URL') ?>
    <button class="btn btn-primary">
        <?php if($item->getID() !== null): ?>
            Edit
        <?php else: ?>
            Create
        <?php endif; ?>
    </button>
</form>