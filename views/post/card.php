<?php 
// $categories = [];
// foreach($post->getCategories() as $k => $category){
//     $url =  $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
//     $categories[] = <<<HTML
//     <a href='$url'>{$category->getName()}</a>
// HTML;    
// }
// array_map method
$categories = array_map(function($category) use ($router) {
    $url =  $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    return <<<HTML
    <a href='$url'>{$category->getName()}</a>
HTML;
}, $post->getCategories());
    

?>

<div class="card">
    <div class="card-body">
        <h1 class="card-title"><?= $post->getName() ?></h1>
        <p class="text-muted"><?= $post->getCreated()->format('d F Y') ?>
            <?php if(!empty($post->getCategories())) : ?> 
            ::
            <?= implode(', ', $categories) ?> 
        <?php endif; ?> 
        </p>
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary">Read More</a>                
        </p>
    </div>
</div>