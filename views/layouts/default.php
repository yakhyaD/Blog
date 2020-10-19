<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title><?= $title ?? 'My blog '?></title>
    <style>
        .navbar-brand {
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">My blog</a>
    </nav>
    <div class="container my-4">
        <?= $content ?>
    </div>
    <footer>
        <div class="container my-4">
            <p>Page generated in <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> </p>
        </div>
    </footer>
</body>
</html>   