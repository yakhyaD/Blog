<?php
require '../vendor/autoload.php';

define('DEBUG_TIME', microtime(true));
define('VIEW_PATH',  dirname(__DIR__) . '/views');
/** Debugger whoops */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if(isset($_GET['page']) && $_GET['page'] === '1'){
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $get = $_GET;
    unset($get['page']);
    $query = http_build_query($get);
    if(!empty($query)){
        $uri .= '?' . $query;
    }
    header('location: ' . $uri);
    http_response_code(301);
    exit();
}

$router = new App\Router(VIEW_PATH);
$router
    ->get('/', 'post/index', 'home')
    ->get('/blog/category/[*:slug]-[i:id]', 'category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->run();
