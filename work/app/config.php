<?php

define('DSN','mysql:host=db;dbname=myapp;charset=utf8mb4');
define('DB_USER', 'myappuser');
define('DB_PASS', 'myapppass');

require_once('Token.php');
require_once('Database.php');
require_once('Todo.php');
require_once('Folder.php');

session_start();
?>