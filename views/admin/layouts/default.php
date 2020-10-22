<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title><?= $title ?? 'My blog '?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .navbar-brand {
            color: white;
        }
        .navbar-nav  {
            font-size: 18px;
            margin-top: 12px;

        }
        .nav-item {
            
            text-decoration: none;
            list-style: none;
        }
        .nav-link {
            color: white;
            margin-left: 10px;
        }

    </style>
</head>
<body class="d-flex flex-column h-100 ">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">My blog</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?= $router->url('admin_posts') ?>" class="nav-link">Articles</a>
            </li>
            <li class="nav-item">
                <a href="<?= $router->url('admin_categories') ?>" class="nav-link">Categories</a>
            </li>
        </ul>
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