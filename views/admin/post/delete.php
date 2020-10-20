<?php

use App\Auth;
use App\Connection;
use App\Table\PostTable;

Auth::check();

$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$table->delete($params['id']);


header('location: ' . $router->url('admin_posts') . '?delete=1');
http_response_code(301);
exit();