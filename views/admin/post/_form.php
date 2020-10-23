<form action="" method="POST">
    <?= $form->input('name', 'Name') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->select('categories_ids', 'Categories', $allCategories) ?>
    <?= $form->input('created', 'Created At') ?>
    <?= $form->textarea('content', 'Content') ?>
    <button class="btn btn-primary">
        <?php if($post->getID() !== null): ?>
            Edit
        <?php else: ?>
            Create
        <?php endif; ?>
    </button>
</form>