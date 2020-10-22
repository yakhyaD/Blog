<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);


header('location: ' . $router->url('admin_categories') . '?delete=1');
http_response_code(301);
exit();